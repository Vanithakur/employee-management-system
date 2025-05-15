<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $departments = Department::all();

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'data' => $departments
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Failed to fetch departments.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:departments,name',
            ]);

            $department = Department::create($validated);

            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => 'Department created successfully.',
                'department' => $department
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
                'error' => 'Failed to create department.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);

            $department->delete();

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Department deleted successfully.'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'error' => 'Department not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Failed to delete department.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
