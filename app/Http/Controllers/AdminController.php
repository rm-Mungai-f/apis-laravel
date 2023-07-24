<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\UserRole;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

        public function assign_roles(Request $request): JsonResponse
        {
            try {
                $validatedData = $request->validate([
                    'user_id' => 'required',
                    'role_id' => 'required',
                ], [
                    'user_id.required' => 'Please enter a user id.',
                    'role_id.required' => 'Please enter a role id.',
                ]);

                $user_role = new UserRole();
                $user_role->user_id = $validatedData['user_id'];
                $user_role->role_id = $validatedData['role_id'];
                $user_role->save();

                return response()->json(['message' => 'Role assigned successfully'], 200);
            } catch (ValidationException $e) {
                $errors = $e->validator->errors()->all();
                return response()->json(['errors' => $errors], 422);
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage(); // Get the specific error message
                Log::error($errorMessage); // Log the error message for debugging purposes

                return response()->json(['error' => $errorMessage], 500);
            }
        }

}
