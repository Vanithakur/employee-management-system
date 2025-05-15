<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::with('department', 'role')->paginate(10);
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'data' => $employees
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Failed to fetch employees.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email',
                'phone' => 'required|string|max:15',
                'department_id' => 'required|exists:departments,id',
                'role_id' => 'required|exists:roles,id',
                'profile_photo' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('profile_photo')) {
                $data['profile_photo'] = $request->file('profile_photo')->store('employees', 'public');
            }

            $employee = Employee::create($data);

            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => 'Employee created successfully.',
                'employee' => $employee
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
                'error' => 'Failed to create employee.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $employee = Employee::with('department', 'role')->findOrFail($id);
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'data' => $employee
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'error' => 'Employee not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Failed to fetch employee.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email',
                'phone' => 'required|string|max:15',
                'department_id' => 'required|exists:departments,id',
                'role_id' => 'required|exists:roles,id',
                'profile_photo' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('profile_photo')) {
                $data['profile_photo'] = $request->file('profile_photo')->store('employees', 'public');
            }

            $employee->update($data);

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Employee updated successfully.',
                'employee' => $employee
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'error' => 'Employee not found.'
            ], 404);
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
                'error' => 'Failed to update employee.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Employee deleted successfully.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'error' => 'Employee not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Failed to delete employee.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
