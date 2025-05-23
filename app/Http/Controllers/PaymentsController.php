<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Payment;
use App\Models\Sale;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        return view('admin.payments.index');
    }

    public function getPayments(Request $request)
    {
        if ($request->ajax()) {
            $payments = Payment::with(['sale', 'user'])->select('payments.*');
            return DataTables::of($payments)
            ->addIndexColumn()
                ->addColumn('sale_code', function ($payment) {
                    return $payment->sale ? $payment->sale->sale_code : 'N/A';
                })
                ->addColumn('user_name', function ($payment) {
                    return $payment->user ? $payment->user->name : 'N/A';
                })
                ->editColumn('amount', function ($payment) {
                    return number_format($payment->amount, 2);
                })
                ->editColumn('payment_date', function ($payment) {
                    return $payment->payment_date->format('Y-m-d');
                })
                ->addColumn('action', function ($payment) {
                    return '
                        <div class="btn-group" role="group" aria-label="Payment Actions">
                            <button class="btn btn-sm btn-info view-payment me-1 text-white" data-id="' . $payment->id . '" title="View" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-payment me-1 text-white" data-id="' . $payment->id . '" title="Edit" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-payment" data-id="' . $payment->id . '" title="Delete" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,mobile',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sale = Sale::findOrFail($request->sale_id);
        $newPaidAmount = $sale->paid_amount + $request->amount;
        if ($newPaidAmount > $sale->total_amount) {
            return response()->json(['error' => 'Total paid amount cannot exceed sale total'], 422);
        }

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'sale_id' => $request->sale_id,
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
            return response()->json(['message' => 'Payment created successfully', 'payment' => $payment], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create payment: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $payment = Payment::with(['sale', 'user'])->findOrFail($id);
        return response()->json($payment);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $oldAmount = $payment->amount;
        $sale = Sale::findOrFail($payment->sale_id);

        $validator = Validator::make($request->all(), [
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,mobile',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $newPaidAmount = ($sale->paid_amount - $oldAmount) + $request->amount;
        if ($newPaidAmount > $sale->total_amount) {
            return response()->json(['error' => 'Total paid amount cannot exceed sale total'], 422);
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'sale_id' => $request->sale_id,
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
            return response()->json(['message' => 'Payment updated successfully', 'payment' => $payment]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update payment: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $sale = Sale::findOrFail($payment->sale_id);

        DB::beginTransaction();
        try {
            $newPaidAmount = $sale->paid_amount - $payment->amount;
            $sale->update([
                'paid_amount' => $newPaidAmount,
                'due_amount' => $sale->total_amount - $newPaidAmount,
            ]);

            $payment->delete();

            DB::commit();
            return response()->json(['message' => 'Payment deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete payment: ' . $e->getMessage()], 500);
        }
    }
}