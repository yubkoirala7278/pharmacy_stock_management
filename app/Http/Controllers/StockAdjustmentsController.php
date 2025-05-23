<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StockAdjustment;
use App\Models\Medicine;

use Illuminate\Http\Request;

class StockAdjustmentsController extends Controller
{
    public function index()
    {
        return view('admin.stock_adjustments.index');
    }

    public function getAdjustments(Request $request)
    {
        if ($request->ajax()) {
            $adjustments = StockAdjustment::with(['medicine', 'user'])->select('stock_adjustments.*');
            return DataTables::of($adjustments)
            ->addIndexColumn()
                ->addColumn('medicine_name', function ($adjustment) {
                    return $adjustment->medicine ? $adjustment->medicine->name : 'N/A';
                })
                ->addColumn('user_name', function ($adjustment) {
                    return $adjustment->user ? $adjustment->user->name : 'N/A';
                })
                ->editColumn('adjustment_date', function ($adjustment) {
                    return $adjustment->adjustment_date->format('Y-m-d');
                })
                ->addColumn('action', function ($adjustment) {
                    return '
                        <div class="btn-group" role="group" aria-label="Adjustment Actions">
                            <button class="btn btn-sm btn-info view-adjustment me-1 text-white" data-id="' . $adjustment->id . '" title="View" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-adjustment me-1 text-white" data-id="' . $adjustment->id . '" title="Edit" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-adjustment" data-id="' . $adjustment->id . '" title="Delete" style="transition: all 0.2s ease-in-out;">
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
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:add,remove',
            'reason' => 'nullable|string|max:500',
            'adjustment_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $medicine = Medicine::findOrFail($request->medicine_id);
        if ($request->type === 'remove' && $medicine->stock_quantity < $request->quantity) {
            return response()->json(['error' => "Insufficient stock for {$medicine->name}"], 422);
        }

        DB::beginTransaction();
        try {
            $adjustment = StockAdjustment::create([
                'medicine_id' => $request->medicine_id,
                'user_id' => auth()->id(),
                'quantity' => $request->quantity,
                'type' => $request->type,
                'reason' => $request->reason,
                'adjustment_date' => $request->adjustment_date,
            ]);

            // Update medicine stock
            if ($request->type === 'add') {
                $medicine->increment('stock_quantity', $request->quantity);
            } else {
                $medicine->decrement('stock_quantity', $request->quantity);
            }

            DB::commit();
            return response()->json(['message' => 'Stock adjustment created successfully', 'adjustment' => $adjustment], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create adjustment: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $adjustment = StockAdjustment::with(['medicine', 'user'])->findOrFail($id);
        return response()->json($adjustment);
    }

    public function update(Request $request, $id)
    {
        $adjustment = StockAdjustment::findOrFail($id);
        $oldQuantity = $adjustment->quantity;
        $oldType = $adjustment->type;
        $medicine = Medicine::findOrFail($adjustment->medicine_id);

        $validator = Validator::make($request->all(), [
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:add,remove',
            'reason' => 'nullable|string|max:500',
            'adjustment_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $newMedicine = Medicine::findOrFail($request->medicine_id);
        // Revert old adjustment
        if ($oldType === 'add') {
            $medicine->decrement('stock_quantity', $oldQuantity);
        } else {
            $medicine->increment('stock_quantity', $oldQuantity);
        }

        // Validate new stock
        if ($request->type === 'remove' && $newMedicine->stock_quantity < $request->quantity) {
            // Re-apply old adjustment if validation fails
            if ($oldType === 'add') {
                $medicine->increment('stock_quantity', $oldQuantity);
            } else {
                $medicine->decrement('stock_quantity', $oldQuantity);
            }
            return response()->json(['error' => "Insufficient stock for {$newMedicine->name}"], 422);
        }

        DB::beginTransaction();
        try {
            $adjustment->update([
                'medicine_id' => $request->medicine_id,
                'quantity' => $request->quantity,
                'type' => $request->type,
                'reason' => $request->reason,
                'adjustment_date' => $request->adjustment_date,
            ]);

            // Apply new adjustment
            if ($request->type === 'add') {
                $newMedicine->increment('stock_quantity', $request->quantity);
            } else {
                $newMedicine->decrement('stock_quantity', $request->quantity);
            }

            DB::commit();
            return response()->json(['message' => 'Stock adjustment updated successfully', 'adjustment' => $adjustment]);
        } catch (\Exception $e) {
            DB::rollBack();
            // Re-apply old adjustment on failure
            if ($oldType === 'add') {
                $medicine->increment('stock_quantity', $oldQuantity);
            } else {
                $medicine->decrement('stock_quantity', $oldQuantity);
            }
            return response()->json(['error' => 'Failed to update adjustment: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $adjustment = StockAdjustment::findOrFail($id);
        $medicine = Medicine::findOrFail($adjustment->medicine_id);

        DB::beginTransaction();
        try {
            // Revert stock adjustment
            if ($adjustment->type === 'add') {
                $medicine->decrement('stock_quantity', $adjustment->quantity);
            } else {
                $medicine->increment('stock_quantity', $adjustment->quantity);
            }

            $adjustment->delete();

            DB::commit();
            return response()->json(['message' => 'Stock adjustment deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete adjustment: ' . $e->getMessage()], 500);
        }
    }
}
