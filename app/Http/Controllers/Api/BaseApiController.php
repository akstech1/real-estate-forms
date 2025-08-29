<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

abstract class BaseApiController extends Controller
{
    use ApiResponseTrait;

    /**
     * Handle common API operations and provide base functionality
     */
    
    /**
     * Return paginated response
     *
     * @param mixed $data
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     * @param string $message
     * @return JsonResponse
     */
    protected function paginatedResponse($data, int $total, int $perPage, int $currentPage, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return $this->successResponse([
            'items' => $data,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => ceil($total / $perPage),
                'from' => (($currentPage - 1) * $perPage) + 1,
                'to' => min($currentPage * $perPage, $total),
            ]
        ], $message);
    }

    /**
     * Return empty success response
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function emptyResponse(string $message = 'No data found'): JsonResponse
    {
        return $this->successResponse([], $message);
    }
}
