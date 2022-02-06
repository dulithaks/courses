<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends BaseApiController
{
    private int $pageSize = 5;
    private ?UserService $userService = null;
    private User $user;

    public function __construct(User $user)
    {
        $this->userService = new UserService();
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
        return $this->successResponse($this->user->all());
    }

    /**
     * Create
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => ['required', 'email'],
            ]);
            $user = $this->user->create($request->all());
            return $this->createResponse($user);
        } catch (ValidationException $e) {
            return $this->validationFailResponse($e);
        } catch (Exception $e) {
            return $this->failResponse($e);
        }
    }

    /**
     * Delete user with associate data
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function delete(User $user): JsonResponse
    {
        try {
            $this->userService->delete($user);
            return $this->deleteResponse();
        } catch (ValidationException $e) {
            return $this->validationFailResponse($e);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse($e);
        } catch (Exception $e) {
            return $this->failResponse($e);
        }
    }
}