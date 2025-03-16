<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    public function get(User $user): User;

    public function getAll(Request $request): Collection;

    public function create(CreateUserRequest $request): User;

    public function update(UpdateUserRequest $request, User $user): User;

    public function delete(User $user): bool;
}
