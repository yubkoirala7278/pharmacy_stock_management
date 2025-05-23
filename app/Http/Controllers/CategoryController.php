<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select('id', 'name', 'description', 'created_at');
            return DataTables::of($categories)
            ->addIndexColumn()
                ->addColumn('action', function ($category) {
                    return '
                        <div class="btn-group" role="group" aria-label="Category Actions">
                            <button class="btn btn-sm btn-info view-category me-1 text-white" data-id="' . $category->id . '" title="View" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-category me-1 text-white" data-id="' . $category->id . '" title="Edit" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-category" data-id="' . $category->id . '" title="Delete" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->editColumn('description', function ($category) {
                    return $category->description ? Str::limit($category->description, 50) : 'N/A';
                })
                ->editColumn('created_at', function ($category) {
                    return $category->created_at->format('Y-m-d');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Category added successfully', 'category' => $category], 201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        try {
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cannot delete category because it is linked to medicines'], 422);
        }
    }
}

