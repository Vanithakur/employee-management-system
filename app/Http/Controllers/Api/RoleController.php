<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'data' => $roles
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Failed to fetch roles',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
            ]);

            $role = Role::create($validated);

            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => 'Role created successfully',
                'data' => $role
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 422,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Failed to create role',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);

            $role->delete();

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Role deleted successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'error' => 'Role not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Failed to delete role',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
