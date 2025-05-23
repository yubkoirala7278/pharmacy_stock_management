<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select('users.*');
            return DataTables::of($users)
                ->editColumn('role', function ($user) {
                    return ucfirst($user->role);
                })
                ->addColumn('action', function ($user) {
                    return '
                        <div class="btn-group" role="group" aria-label="User Actions">
                            <button class="btn btn-sm btn-info view-user me-1 text-white" data-id="' . $user->id . '" title="View" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-user me-1 text-white" data-id="' . $user->id . '" title="Edit" style="transition: all 0.2s ease-in-out;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-user" data-id="' . $user->id . '" title="Delete" style="transition: all 0.2s ease-in-out;">
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,pharmacist,staff',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            DB::commit();
            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create user: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,pharmacist,staff',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            DB::commit();
            return response()->json(['message' => 'User updated successfully', 'user' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update user: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'Cannot delete your own account'], 422);
        }

        // Prevent deleting last admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return response()->json(['error' => 'Cannot delete the last admin user'], 422);
        }

        DB::beginTransaction();
        try {
            $user->delete();

            DB::commit();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete user: ' . $e->getMessage()], 500);
        }
    }
}
