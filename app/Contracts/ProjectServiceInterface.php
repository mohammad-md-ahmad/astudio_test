<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\Projects\CreateProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ProjectServiceInterface
{
    public function get(Project $project): Project;

    public function getAll(Request $request): Collection;

    public function create(CreateProjectRequest $request): Project;

    public function update(UpdateProjectRequest $request, Project $project): Project;

    public function delete(Project $project): bool;
}
