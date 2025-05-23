<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Supplier;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index()
    {
        return view('admin.suppliers.index');
    }

    public function getSuppliers(Request $request)
    {
        if ($request->ajax()) {
            $suppliers = Supplier::select('id', 'name', 'contact_person', 'email', 'phone', 'address', 'created_at');
            return DataTables::of($suppliers)
             ->addIndexColumn()
                ->addColumn('action', function ($supplier) {
                    return '
                        <div class="btn-group" role="group" aria-label="Supplier Actions">
                            <button class="btn btn-sm btn-info view-supplier me-1 text-white" data-id="' . $supplier->id . '" title="View" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-supplier me-1 text-white" data-id="' . $supplier->id . '" title="Edit" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-supplier" data-id="' . $supplier->id . '" title="Delete" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->editColumn('contact_person', function ($supplier) {
                    return $supplier->contact_person ?? 'N/A';
                })
                ->editColumn('email', function ($supplier) {
                    return $supplier->email ?? 'N/A';
                })
                ->editColumn('phone', function ($supplier) {
                    return $supplier->phone ?? 'N/A';
                })
                ->editColumn('address', function ($supplier) {
                    return $supplier->address ? Str::limit($supplier->address, 50) : 'N/A';
                })
                ->editColumn('created_at', function ($supplier) {
                    return $supplier->created_at->format('Y-m-d');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $supplier = Supplier::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json(['message' => 'Supplier added successfully', 'supplier' => $supplier], 201);
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $supplier->update([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json(['message' => 'Supplier updated successfully', 'supplier' => $supplier]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        try {
            $supplier->delete();
            return response()->json(['message' => 'Supplier deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cannot delete supplier because it is linked to purchases'], 422);
        }
    }
}
