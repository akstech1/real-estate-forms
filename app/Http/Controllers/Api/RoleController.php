<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    use ApiResponseTrait;
    /**
     * Get all roles except Super Admin
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Get all roles except Super Admin
            $roles = Role::where('name', '!=', 'Super Admin')
                        ->orderBy('id')
                        ->get(['id', 'name']);

            // Format roles data
            $formattedRoles = $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name
                ];
            })->toArray();

            return $this->successResponse($formattedRoles, 'Roles retrieved successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }
}
