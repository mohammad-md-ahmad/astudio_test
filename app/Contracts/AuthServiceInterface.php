<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function register(RegisterRequest $request): array;

    public function login(LoginRequest $request): array;

    public function logout(Request $request): bool;
}
