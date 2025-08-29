<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordResetOtp;
use Carbon\Carbon;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Register a new user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8|max:255',
                'role_name' => 'required|string|exists:roles,name|max:255',
            ], [
                'name.required' => 'Name is required.',
                'name.string' => 'Name must be a string.',
                'name.max' => 'Name cannot exceed 255 characters.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.unique' => 'This email is already registered.',
                'email.max' => 'Email cannot exceed 255 characters.',
                'password.required' => 'Password is required.',
                'password.string' => 'Password must be a string.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.max' => 'Password cannot exceed 255 characters.',
                'role_name.required' => 'Role name is required.',
                'role_name.string' => 'Role name must be a string.',
                'role_name.exists' => 'The specified role does not exist.',
                'role_name.max' => 'Role name cannot exceed 255 characters.',
            ]);

            if ($validator->fails()) {
                return $this->validationErrorResponse($validator->errors()->toArray(), 'Validation failed');
            }

            // Get the role
            $role = Role::where('name', $request->role_name)->first();
            if (!$role) {
                return $this->errorResponse('The specified role does not exist.', 422);
            }

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign the role to the user
            $user->assignRole($role);

            // Return success response with user data (excluding password)
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_name' => $role->name,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            ];

            return $this->successResponse($userData, 'User registered successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:1',
            ], [
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.max' => 'Email cannot exceed 255 characters.',
                'password.required' => 'Password is required.',
                'password.string' => 'Password must be a string.',
                'password.min' => 'Password cannot be empty.',
            ]);

            if ($validator->fails()) {
                return $this->validationErrorResponse($validator->errors()->toArray(), 'Validation failed');
            }

            // Attempt to authenticate user
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                
                // Get user's roles
                $roles = $user->getRoleNames();
                $primaryRole = $roles->first() ?: 'No Role Assigned';

                // Generate token (if using Sanctum)
                $token = $user->createToken('auth-token')->plainTextToken;

                // Return success response with user data and token
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_name' => $primaryRole,
                    'token' => $token,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                ];

                return $this->successResponse($userData, 'Login successful.');
            }

            // Authentication failed
            return $this->errorResponse('Invalid email or password.', 401);

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Get the authenticated user
            $user = $request->user();
            
            if ($user) {
                // Revoke all tokens for the user
                $user->tokens()->delete();
                
                return $this->successResponse([], 'Logout successful.');
            }

            return $this->errorResponse('No authenticated user found.', 401);

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Send OTP for password reset
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email|max:255',
            ], [
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.exists' => 'No account found with this email address.',
                'email.max' => 'Email cannot exceed 255 characters.',
            ]);

            if ($validator->fails()) {
                return $this->validationErrorResponse($validator->errors()->toArray(), 'Validation failed');
            }

            $email = $request->email;

            // Generate 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Set expiration time (10 minutes from now)
            $expiresAt = Carbon::now()->addMinutes(10);

            // Delete any existing OTPs for this email
            PasswordResetOtp::where('email', $email)->delete();

            // Create new OTP record
            PasswordResetOtp::create([
                'email' => $email,
                'otp' => $otp,
                'expires_at' => $expiresAt,
                'is_used' => false,
            ]);

            // Send OTP via email
            try {
                Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
                    $message->to($email)
                            ->subject('Password Reset OTP');
                });
            } catch (\Exception $e) {
                // If email fails, delete the OTP record
                PasswordResetOtp::where('email', $email)->delete();
                return $this->errorResponse('Failed to send OTP email. Please try again.', 500);
            }

            return $this->successResponse(['email' => $email], 'OTP sent successfully. Please check your email.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Validate OTP for password reset
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validateOtp(Request $request): JsonResponse
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'otp' => 'required|string|size:6',
            ], [
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.max' => 'Email cannot exceed 255 characters.',
                'otp.required' => 'OTP is required.',
                'otp.string' => 'OTP must be a string.',
                'otp.size' => 'OTP must be exactly 6 characters.',
            ]);

            if ($validator->fails()) {
                return $this->validationErrorResponse($validator->errors()->toArray(), 'Validation failed');
            }

            $email = $request->email;
            $otp = $request->otp;

            // Find the OTP record
            $otpRecord = PasswordResetOtp::where('email', $email)
                                        ->where('otp', $otp)
                                        ->first();

            if (!$otpRecord) {
                return $this->errorResponse('Invalid OTP code.', 422);
            }

            if ($otpRecord->isExpired()) {
                return $this->errorResponse('OTP has expired. Please request a new one.', 422);
            }

            if ($otpRecord->is_used) {
                return $this->errorResponse('OTP has already been used.', 422);
            }

            // Mark OTP as used
            $otpRecord->update(['is_used' => true]);

            // Generate a temporary reset token (valid for 5 minutes)
            $resetToken = \Str::random(60);
            
            // Store the reset token in cache for 5 minutes
            \Cache::put("password_reset_{$email}", $resetToken, 300);

            return $this->successResponse([
                'email' => $email,
                'reset_token' => $resetToken,
                'message' => 'OTP validated successfully. You can now reset your password.'
            ], 'OTP validated successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Reset password using validated OTP
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email|max:255',
                'reset_token' => 'required|string|max:255',
                'password' => 'required|string|min:8|max:255',
                'password_confirmation' => 'required|same:password',
            ], [
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.exists' => 'No account found with this email address.',
                'email.max' => 'Email cannot exceed 255 characters.',
                'reset_token.required' => 'Reset token is required.',
                'reset_token.string' => 'Reset token must be a string.',
                'reset_token.max' => 'Reset token cannot exceed 255 characters.',
                'password.required' => 'Password is required.',
                'password.string' => 'Password must be a string.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.max' => 'Password cannot exceed 255 characters.',
                'password_confirmation.required' => 'Password confirmation is required.',
                'password_confirmation.same' => 'Password confirmation does not match.',
            ]);

            if ($validator->fails()) {
                return $this->validationErrorResponse($validator->errors()->toArray(), 'Validation failed');
            }

            $email = $request->email;
            $resetToken = $request->reset_token;
            $password = $request->password;

            // Verify reset token
            $cachedToken = \Cache::get("password_reset_{$email}");
            if (!$cachedToken || $cachedToken !== $resetToken) {
                return $this->errorResponse('Invalid or expired reset token.', 422);
            }

            // Find the user
            $user = User::where('email', $email)->first();
            if (!$user) {
                return $this->errorResponse('User not found.', 404);
            }

            // Update password
            $user->update([
                'password' => Hash::make($password),
            ]);

            // Clear the reset token from cache
            \Cache::forget("password_reset_{$email}");

            // Delete any remaining OTP records for this email
            PasswordResetOtp::where('email', $email)->delete();

            return $this->successResponse([], 'Password reset successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }
}
