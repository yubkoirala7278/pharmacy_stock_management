<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return view('admin.sales.index');
    }

    public function getSales(Request $request)
    {
        if ($request->ajax()) {
            $sales = Sale::with(['user' => function ($query) {
                $query->select('id', 'name');
            }])->select('sales.*');
            return DataTables::of($sales)
                ->addIndexColumn()
                ->addColumn('user_name', function ($sale) {
                    return $sale->user ? $sale->user->name : 'N/A';
                })
                ->addColumn('action', function ($sale) {
                    return '
                        <div class="btn-group" role="group" aria-label="Sale Actions">
                            <button class="btn btn-sm btn-info view-sale me-1 text-white" data-id="' . $sale->id . '" title="View" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-sale me-1 text-white" data-id="' . $sale->id . '" title="Edit" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-success add-payment me-1" data-id="' . $sale->id . '" title="Add Payment" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-money-bill"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-sale" data-id="' . $sale->id . '" title="Delete" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->editColumn('customer_name', function ($sale) {
                    return $sale->customer_name ?? 'N/A';
                })
                ->editColumn('sale_date', function ($sale) {
                    return $sale->sale_date->format('Y-m-d');
                })
                ->editColumn('total_amount', function ($sale) {
                    return number_format($sale->total_amount, 2);
                })
                ->editColumn('paid_amount', function ($sale) {
                    return number_format($sale->paid_amount, 2);
                })
                ->editColumn('due_amount', function ($sale) {
                    return number_format($sale->due_amount, 2);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sale_date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'paid_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Validate stock availability
        foreach ($request->items as $item) {
            $medicine = Medicine::findOrFail($item['medicine_id']);
            if ($medicine->stock_quantity < $item['quantity']) {
                return response()->json(['error' => "Insufficient stock for {$medicine->name}"], 422);
            }
        }

        $totalAmount = collect($request->items)->sum(fn($item) => $item['quantity'] * $item['unit_price']);
        $paidAmount = $request->paid_amount;
        if ($paidAmount > $totalAmount) {
            return response()->json(['error' => 'Paid amount cannot exceed total amount'], 422);
        }

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'sale_code' => 'SALE-' . Str::random(8),
                'sale_date' => $request->sale_date,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'due_amount' => $totalAmount - $paidAmount,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
            ]);

            foreach ($request->items as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);

                // Decrease medicine stock
                $medicine = Medicine::findOrFail($item['medicine_id']);
                $medicine->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();
            return response()->json(['message' => 'Sale created successfully', 'sale' => $sale], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create sale: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $sale = Sale::with(['user', 'saleDetails.medicine', 'payments'])->findOrFail($id);
        return response()->json($sale);
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'sale_date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'paid_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $totalAmount = collect($request->items)->sum(fn($item) => $item['quantity'] * $item['unit_price']);
        $paidAmount = $request->paid_amount;
        if ($paidAmount > $totalAmount) {
            return response()->json(['error' => 'Paid amount cannot exceed total amount'], 422);
        }

        // Validate stock availability after reverting old quantities
        DB::beginTransaction();
        try {
            // Revert stock quantities for existing sale details
            foreach ($sale->saleDetails as $detail) {
                $medicine = Medicine::findOrFail($detail->medicine_id);
                $medicine->increment('stock_quantity', $detail->quantity);
            }

            // Check stock for new items
            foreach ($request->items as $item) {
                $medicine = Medicine::findOrFail($item['medicine_id']);
                if ($medicine->stock_quantity < $item['quantity']) {
                    DB::rollBack();
                    return response()->json(['error' => "Insufficient stock for {$medicine->name}"], 422);
                }
            }

            // Delete existing sale details
            $sale->saleDetails()->delete();

            // Update sale
            $sale->update([
                'sale_date' => $request->sale_date,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'due_amount' => $totalAmount - $paidAmount,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
            ]);

            // Create new sale details
            foreach ($request->items as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);

                // Decrease medicine stock
                $medicine = Medicine::findOrFail($item['medicine_id']);
                $medicine->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();
            return response()->json(['message' => 'Sale updated successfully', 'sale' => $sale]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update sale: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        DB::beginTransaction();
        try {
            // Revert stock quantities
            foreach ($sale->saleDetails as $detail) {
                $medicine = Medicine::findOrFail($detail->medicine_id);
                $medicine->increment('stock_quantity', $detail->quantity);
            }

            // Delete sale details, payments, and sale
            $sale->saleDetails()->delete();
            $sale->payments()->delete();
            $sale->delete();

            DB::commit();
            return response()->json(['message' => 'Sale deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete sale: ' . $e->getMessage()], 500);
        }
    }

    public function storePayment(Request $request, $saleId)
    {
        $sale = Sale::findOrFail($saleId);

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,mobile',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $newPaidAmount = $sale->paid_amount + $request->amount;
        if ($newPaidAmount > $sale->total_amount) {
            return response()->json(['error' => 'Total paid amount cannot exceed total amount'], 422);
        }

        DB::beginTransaction();
        try {
            Payment::create([
                'sale_id' => $sale->id,
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
            ]);

            $sale->update([
                'paid_amount' => $newPaidAmount,
                'due_amount' => $sale->total_amount - $newPaidAmount,
            ]);

            DB::commit();
            return response()->json(['message' => 'Payment added successfully', 'sale' => $sale]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to add payment: ' . $e->getMessage()], 500);
        }
    }
}
