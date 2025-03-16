<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Token;
use Laravel\Passport\TransientToken;

class UserService implements UserServiceInterface
{
    public function get(User $user): User
    {
        try {
            return $user;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function getAll(Request $request): Collection
    {
        try {
            return User::all();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function create(CreateUserRequest $request): User
    {
        try {
            return DB::transaction(function () use ($request) {
                $user = new User;
                $user->fill($request->only($user->getFillable()));
                $user->save();

                return $user;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function update(UpdateUserRequest $request, User $user): User
    {
        try {
            return DB::transaction(function () use ($request, $user) {
                $user->fill($request->only($user->getFillable()));
                $user->save();

                return $user;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function delete(User $user): bool
    {
        try {
            return DB::transaction(function () use ($user) {
                $user->tokens->each(function (Token|TransientToken $token) {
                    $token->revoke();
                });
                $user->projects()->detach();
                $user->timesheets()->delete();

                return $user->delete();
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }
}
