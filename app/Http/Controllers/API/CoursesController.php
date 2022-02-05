<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CoursesController extends BaseApiController
{
    private int $pageSize = 5;
    private Course $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * All users with pagination
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse($this->course->paginate($request->input('per_page', $this->pageSize)));
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
            $request->validate(['title' => 'required']);
            return $this->createResponse($this->course->create($request->all()));
        } catch (ValidationException $e) {
            return $this->validationFailResponse($e);
        } catch (Exception $e) {
            return $this->failResponse($e);
        }
    }
}