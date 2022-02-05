<?php

namespace App\Http\Controllers\API;

use Exception;
use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use function __;
use function response;

class BaseApiController extends Controller
{
    /**
     * Respond not found
     *
     * @param \Throwable $e
     * @param string|null $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public static function respondNotFound(Throwable $e, string $message = null)
    {
        return response([
            "message" => $message ?? __('responses.model-not-found'),
            "payload" => $e->getMessage(),
            "status" => false
        ], 404);
    }

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
    public function validationFailResponse(ValidationException $e, string $message = null) : JsonResponse
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
    public function failResponse(Exception $e, string $message = null) : JsonResponse
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

    /**
     * Delete response
     *
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFoundResponse(string $message = null) : JsonResponse
    {
        return response()->json([
            "message" => $message ?? __('responses.not-found'),
            "payload" => null,
            "status" => false
        ], 404);
    }
}