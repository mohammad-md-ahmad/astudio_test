<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Exceptions\AuthenticationException;
use Laravel\Passport\Token;
use Laravel\Passport\TransientToken;

class AuthService implements AuthServiceInterface
{
    public function register(RegisterRequest $request): array
    {
        try {
            return DB::transaction(function () use ($request) {
                $user = new User;
                $user->fill($request->only($user->getFillable()));
                $user->save();

                $token = $user->createToken('apiAccessToken')->accessToken;

                return [
                    'token' => $token,
                    'user' => $user,
                ];
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }

    }

    public function login(LoginRequest $request): array
    {
        try {
            if (Auth::attempt($request->all())) {
                /** @var User $user */
                $user = Auth::user();

                return DB::transaction(function () use ($user) {
                    $user->tokens->each(function (Token|TransientToken $token) {
                        $token->revoke();
                    });
                    $user->token();

                    $token = $user->createToken('apiAccessToken')->accessToken;

                    return [
                        'token' => $token,
                        'user' => $user,
                    ];
                });
            }

            throw new AuthenticationException;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function logout(Request $request): bool
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            return DB::transaction(function () use ($user) {
                return $user->token()->revoke();
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }
}
