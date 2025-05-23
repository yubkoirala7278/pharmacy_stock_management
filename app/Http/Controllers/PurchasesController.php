<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public function index()
    {
        return view('admin.purchase.index');
    }

    public function getPurchases(Request $request)
    {
        if ($request->ajax()) {
            $purchases = Purchase::with(['supplier' => function ($query) {
                $query->select('id', 'name');
            }, 'user' => function ($query) {
                $query->select('id', 'name');
            }])->select('purchases.*');
            return DataTables::of($purchases)
                ->addIndexColumn()
                ->addColumn('supplier_name', function ($purchase) {
                    return $purchase->supplier ? $purchase->supplier->name : 'N/A';
                })
                ->addColumn('user_name', function ($purchase) {
                    return $purchase->user ? $purchase->user->name : 'N/A';
                })
                ->addColumn('action', function ($purchase) {
                    return '
                        <div class="btn-group" role="group" aria-label="Purchase Actions">
                            <button class="btn btn-sm btn-info view-purchase me-1 text-white" data-id="' . $purchase->id . '" title="View" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-purchase me-1 text-white" data-id="' . $purchase->id . '" title="Edit" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-purchase" data-id="' . $purchase->id . '" title="Delete" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->editColumn('purchase_date', function ($purchase) {
                    return $purchase->purchase_date->format('Y-m-d');
                })
                ->editColumn('total_amount', function ($purchase) {
                    return number_format($purchase->total_amount, 2);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => auth()->id(),
                'purchase_code' => 'PUR-' . Str::random(8),
                'purchase_date' => $request->purchase_date,
                'total_amount' => collect($request->items)->sum(fn($item) => $item['quantity'] * $item['unit_price']),
            ]);

            foreach ($request->items as $item) {
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);

                // Update medicine stock
                $medicine = Medicine::findOrFail($item['medicine_id']);
                $medicine->increment('stock_quantity', $item['quantity']);
            }

            DB::commit();
            return response()->json(['message' => 'Purchase created successfully', 'purchase' => $purchase], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create purchase: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $purchase = Purchase::with(['supplier', 'user', 'purchaseDetails.medicine'])->findOrFail($id);
        return response()->json($purchase);
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            // Revert stock quantities for existing purchase details
            foreach ($purchase->purchaseDetails as $detail) {
                $medicine = Medicine::findOrFail($detail->medicine_id);
                $medicine->decrement('stock_quantity', $detail->quantity);
            }

            // Delete existing purchase details
            $purchase->purchaseDetails()->delete();

            // Update purchase
            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'total_amount' => collect($request->items)->sum(fn($item) => $item['quantity'] * $item['unit_price']),
            ]);

            // Create new purchase details
            foreach ($request->items as $item) {
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);

                // Update medicine stock
                $medicine = Medicine::findOrFail($item['medicine_id']);
                $medicine->increment('stock_quantity', $item['quantity']);
            }

            DB::commit();
            return response()->json(['message' => 'Purchase updated successfully', 'purchase' => $purchase]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update purchase: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        DB::beginTransaction();
        try {
            // Revert stock quantities
            foreach ($purchase->purchaseDetails as $detail) {
                $medicine = Medicine::findOrFail($detail->medicine_id);
                $medicine->decrement('stock_quantity', $detail->quantity);
            }

            // Delete purchase details and purchase
            $purchase->purchaseDetails()->delete();
            $purchase->delete();

            DB::commit();
            return response()->json(['message' => 'Purchase deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete purchase'], 500);
        }
    }
}
