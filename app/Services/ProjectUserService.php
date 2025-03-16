<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AttributeServiceInterface;
use App\Contracts\ProjectUserServiceInterface;
use App\Http\Requests\ProjectUsers\CreateProjectUserRequest;
use App\Http\Requests\ProjectUsers\DeleteProjectUserRequest;
use App\Models\Project;
use App\Models\ProjectUser;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectUserService implements ProjectUserServiceInterface
{
    public function __construct(
        protected AttributeServiceInterface $attributeService,
    ) {}

    public function get(Project $project): Project
    {
        try {
            return $project->load('users');
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function getAll(Request $request): Collection
    {
        try {
            return Project::with('users')->filter($request)->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw $e;
        }
    }

    public function create(CreateProjectUserRequest $request, Project $project): Project
    {
        try {
            DB::transaction(function () use ($request, $project) {
                $projectUser = new ProjectUser;
                $projectUser->user_id = $request->user_id;
                $projectUser->project_id = $project->id;
                $projectUser->save();
            });

            return $project->load('users');
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function delete(DeleteProjectUserRequest $request, Project $project): bool
    {
        try {
            return DB::transaction(function () use ($request, $project) {
                return ProjectUser::query()->where(function (Builder $query) use ($request, $project) {
                    $query->where('project_id', $project->id)
                        ->where('user_id', $request->user_id);
                })->first()->delete();
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }
}
