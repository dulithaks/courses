<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Course;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use function dd;

class ResultsController extends BaseApiController
{
    private int $pageSize = 5;
    private Course $course;
    private Result $result;
    private User $user;

    public function __construct(Course $course, Result $result, User $user)
    {
        $this->course = $course;
        $this->result = $result;
        $this->user = $user;
    }

    /**
     * All users with pagination
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->user
                ->with(['courses'])
                ->paginate($request->input('per_page', $this->pageSize))
        );
    }

    /**
     * Assign course and result
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => ['required', 'exists:App\Models\User,id'],
                'course_id' => ['required', 'exists:App\Models\Course,id'],
                'status' => [
                    'required',
                    Rule::in([Result::STATUS_NOT_STARTED, Result::STATUS_FAILED, Result::STATUS_PASSED])
                ]
            ]);

            return $this->createResponse($this->result->create($request->all()));
        } catch (ValidationException $e) {
            return $this->validationFailResponse($e);
        } catch (Exception $e) {
            return $this->failResponse($e);
        }
    }

    /**
     * Assign course and result
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Result $result): JsonResponse
    {
        try {
            $data = $request->validate([
                'status' => [
                    'required',
                    Rule::in([Result::STATUS_NOT_STARTED, Result::STATUS_FAILED, Result::STATUS_PASSED])
                ]
            ]);

            return $this->updateResponse($result->update($data));
        } catch (ValidationException $e) {
            return $this->validationFailResponse($e);
        } catch (Exception $e) {
            return $this->failResponse($e);
        }
    }
}