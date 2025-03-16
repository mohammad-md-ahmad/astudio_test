<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceInterface;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService,
    ) {}

    public function get(User $user): JsonResponse
    {
        try {
            $data = $this->userService->get($user);

            return response()->json([
                'message' => trans('User has been retrieved successfully!'),
                'data' => $data->toArray(),
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            /** @var \Illuminate\Support\Collection $data */
            $data = $this->userService->getAll($request);

            return response()->json([
                'message' => trans('Users have been retrieved successfully!'),
                'data' => $data->toArray(),
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        try {
            /** @var User $user */
            $user = $this->userService->create($request);

            return response()->json([
                'message' => trans('User has been created successfully!'),
                'data' => $user->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            /** @var User $user */
            $user = $this->userService->update($request, $user);

            return response()->json([
                'message' => trans('User has been updated successfully!'),
                'data' => $user->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(User $user): JsonResponse
    {
        try {
            $this->userService->delete($user);

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }
}
