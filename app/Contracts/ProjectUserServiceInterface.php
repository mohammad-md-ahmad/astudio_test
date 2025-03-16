<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\ProjectUsers\CreateProjectUserRequest;
use App\Http\Requests\ProjectUsers\DeleteProjectUserRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ProjectUserServiceInterface
{
    public function get(Project $project): Project;

    public function getAll(Request $request): Collection;

    public function create(CreateProjectUserRequest $request, Project $project): Project;

    public function delete(DeleteProjectUserRequest $request, Project $project): bool;
}
