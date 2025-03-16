<?php

namespace App\Http\Controllers;

use App\Contracts\AuthServiceInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Exceptions\AuthenticationException;

class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService,
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->register($request);

            return response()->json([
                'message' => trans('User has been registered successfully!'),
                'data' => $data,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->login($request);

            return response()->json([
                'message' => trans('User has been logged in successfully!'),
                'data' => $data,
            ], Response::HTTP_OK);
        } catch (AuthenticationException $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('Email or password is incorrect!')], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request);

            return response()->json([
                'message' => trans('User has been logged out successfully!'),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }
}
