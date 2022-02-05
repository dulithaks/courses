<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use function __;
use function response;

class BaseApiController extends Controller
{
    /**
     * Common success response
     *
     * @param $data
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, string $message = null): JsonResponse
    {
        return response()->json([
            "message" => $message,
            "payload" => $data,
            "status" => false
        ], 200);
    }

    /**
     * Validation fail response
     *
     * @param \Illuminate\Validation\ValidationException $e
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function validationFailResponse(ValidationException $e, string $message) : JsonResponse
    {
        return response()->json([
            "message" => $message ?? __('responses.validation-fail'),
            "payload" => $e->errors(),
            "status" => false
        ], 422);
    }

    /**
     * Unexpected exception response
     *
     * @param \Exception $e
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function failResponse(Exception $e, string $message) : JsonResponse
    {
        return response()->json([
            "message" => $message ?? __('responses.unknown-ex'),
            "payload" => $e->getMessage(),
            "status" => false
        ], 500);
    }

    /**
     * Create response
     *
     * @param $data
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function createResponse($data, string $message = null) : JsonResponse
    {
        return response()->json([
            "message" => $message ?? __('responses.created'),
            "payload" => $data,
            "status" => true
        ], 201);
    }

    /**
     * Delete response
     *
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteResponse(string $message = null) : JsonResponse
    {
        return response()->json([
            "message" => $message ?? __('responses.deleted'),
            "payload" => null,
            "status" => true
        ], 204);
    }
}