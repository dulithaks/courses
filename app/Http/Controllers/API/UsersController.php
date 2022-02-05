<?php

namespace App\Http\Controllers\API;

use Exception;
use UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function dd;
use function __;
use function response;

class UsersController extends BaseApiController
{
    private int $pageSize = 5;
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
     */
    public function delete(User $user)
    {
        try {
            $this->userService->delete($user);
            return $this->deleteResponse();
        } catch (ValidationException $e) {
            return $this->validationFailResponse($e);
        } catch (Exception $e) {
            return $this->failResponse($e);
        }
    }
}