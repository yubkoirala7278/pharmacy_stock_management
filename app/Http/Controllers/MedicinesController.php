<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MedicinesController extends Controller
{
    public function index()
    {
        return view('admin.medicines.index');
    }

    public function getMedicines(Request $request)
    {
        if ($request->ajax()) {
            $medicines = Medicine::with(['category' => function ($query) {
                $query->select('id', 'name');
            }])->select('medicines.*');
            return DataTables::of($medicines)
                ->addIndexColumn()
                ->addColumn('category_name', function ($medicine) {
                    return $medicine->category ? $medicine->category->name : 'None';
                })
                ->addColumn('action', function ($medicine) {
                    return '
        <div class="btn-group" role="group" aria-label="Medicine Actions">
            <button class="btn btn-sm btn-info view-medicine me-1 text-white" data-id="' . $medicine->id . '" title="View" style="transition: all 0.2s ease-in-out;">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-warning text-white edit-medicine me-1" data-id="' . $medicine->id . '" title="Edit" style="transition: all 0.2s ease-in-out;">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-medicine" data-id="' . $medicine->id . '" title="Delete" style="transition: all 0.2s ease-in-out;">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    ';
                })
                ->editColumn('expiry_date', function ($medicine) {
                    return $medicine->expiry_date ? $medicine->expiry_date->format('Y-m-d') : 'N/A';
                })
                ->editColumn('cost_price', function ($medicine) {
                    return number_format($medicine->cost_price, 2);
                })
                ->editColumn('selling_price', function ($medicine) {
                    return number_format($medicine->selling_price, 2);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'batch_number' => 'required|string|unique:medicines,batch_number',
            'expiry_date' => 'required|date|after:today',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $medicine = Medicine::create([
            'slug' => Str::slug($request->name . '-' . Str::random(5)),
            'name' => $request->name,
            'category_id' => $request->category_id,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return response()->json(['message' => 'Medicine added successfully', 'medicine' => $medicine], 201);
    }

    public function show($id)
    {
        $medicine = Medicine::with('category')->findOrFail($id);
        return response()->json($medicine);
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'batch_number' => 'required|string|unique:medicines,batch_number,' . $id,
            'expiry_date' => 'required|date|after:today',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $medicine->update([
            'slug' => Str::slug($request->name . '-' . Str::random(5)),
            'name' => $request->name,
            'category_id' => $request->category_id,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return response()->json(['message' => 'Medicine updated successfully', 'medicine' => $medicine]);
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        try {
            $medicine->delete();
            return response()->json(['message' => 'Medicine deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cannot delete medicine because it is linked to purchases or sales'], 422);
        }
    }
}
