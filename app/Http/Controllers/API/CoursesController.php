<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CoursesController extends BaseApiController
{
    private int $pageSize = 5;

    /**
     * All users with pagination
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(Course::paginate($request->input('per_page', $this->pageSize)));
    }

    /**
     * Create user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required',
            ]);
            $user = Course::create($request->all());
            return $this->createResponse($user);
        } catch (ValidationException $e) {
            return $this->validationFailResponse($e);
        } catch (Exception $e) {
            return $this->failResponse($e);
        }
    }
}