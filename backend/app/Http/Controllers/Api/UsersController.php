<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\InfoPengguna; // Assuming this model exists
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // For file handling
use Illuminate\Support\Facades\Validator; // For validation
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class UsersController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(): JsonResponse
    {
        // No validation needed for index method
        $users = User::all();
        
        return response()->json([
            'is_success' => true,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,admin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'is_success' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified user.
     */
    public function show($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::findOrFail($id);
        
        return response()->json([
            'is_success' => true,
            'user' => $user
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make(array_merge($request->all(), ['id' => $id]), [
            'id' => 'required|integer|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($id)
            ],
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string|in:user,admin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = User::findOrFail($id);
        $data = $request->only(['name', 'email', 'role']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return response()->json([
            'is_success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([
            'is_success' => true,
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Delete user account
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAccount($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json([
                'is_success' => true,
                'message' => 'User account successfully deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message' => 'Failed to delete user account',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update additional user information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id User ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdateInfo(Request $request, $id)
    {
        // Find the user first (optional, depends if you need user context beyond id)
        $user = User::findOrFail($id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat_tempat_tinggal' => 'required|string|max:500',
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan', 'Lainnya'])], // Adjust options as needed
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();
        $filePath = null;

        // Handle file upload for foto_profile
        if ($request->hasFile('foto_profile')) {
            // Optionally delete old file if updating
            $existingInfo = InfoPengguna::where('user_id', $id)->first();
            if ($existingInfo && $existingInfo->foto_profile) {
                Storage::disk('public')->delete($existingInfo->foto_profile);
            }
            // Store the new file
            $filePath = $request->file('foto_profile')->store('profile_pictures', 'public');
            $validatedData['foto_profile'] = $filePath;
        } else {
            // Prevent overwriting existing photo with null if not provided in update
            unset($validatedData['foto_profile']);
        }


        try {
            $userInfo = InfoPengguna::updateOrCreate(
                ['user_id' => $id], // Conditions to find the record
                $validatedData       // Data to update or create with
            );

            return response()->json([
                'is_success' => true,
                'message' => 'User information saved successfully.',
                'data' => $userInfo
            ], 200); // 200 OK for update, 201 Created might also be suitable on creation

        } catch (\Exception $e) {
            // Log the error internally
            Log::error('Error saving user info: ' . $e->getMessage());

            // Optionally delete uploaded file if DB operation failed
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                 Storage::disk('public')->delete($filePath);
            }

            return response()->json([
                'is_success' => false,
                'message' => 'An error occurred while saving user information.'
                // Optionally include $e->getMessage() in development environments
            ], 500);
        }
    }

    /**
     * Display the specified user's additional information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id User ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function showInfo(Request $request, $id)
    {
        $authenticatedUser = $request->user();

        if ($authenticatedUser->id != $id && !$authenticatedUser->is_admin) {
             return response()->json([
                'is_success' => false,
                'message' => 'Forbidden.'
             ], 403);
        }

        try {
            $userInfo = InfoPengguna::where('user_id', $id)->first(); // Use first() instead of findOrFail() to handle not found case gracefully

            if (!$userInfo) {
                return response()->json([
                    'is_success' => false,
                    'message' => 'User information not found.'
                ], 404);
            }

            // Optionally, format the photo URL if stored as a relative path
            if ($userInfo->foto_profile) {
                 $userInfo->foto_profile_url = Storage::url($userInfo->foto_profile);
            }


            return response()->json([
                'is_success' => true,
                'data' => $userInfo
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching user info: ' . $e->getMessage());
            return response()->json([
                'is_success' => false,
                'message' => 'An error occurred while fetching user information.'
            ], 500);
        }
    }
}
