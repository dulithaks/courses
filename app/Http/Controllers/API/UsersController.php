<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends BaseApiController
{
    private int $pageSize = 5;
    private ?UserService $userService = null;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * All users with pagination
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->successResponse(User::paginate($request->input('per_page', $this->pageSize)));
    }

    /**
     * Create user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => ['required', 'email'],
            ]);
            $user = User::create($request->all());
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
    public function delete(User $user)
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