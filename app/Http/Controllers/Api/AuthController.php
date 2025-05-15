<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => 'User registered successfully',
                'token' => $user->createToken('api-token')->plainTextToken,
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
                'error' => 'Registration failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'status_code' => 404,
                    'error' => 'User not found'
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'status_code' => 401,
                    'error' => 'Invalid credentials'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Login successful',
                'token' => $user->createToken('api-token')->plainTextToken,
            ], 200);

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
                'error' => 'Login failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Logged out successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => 'Logout failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
