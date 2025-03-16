<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ProjectServiceInterface;
use App\Http\Requests\Projects\CreateProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectService implements ProjectServiceInterface
{
    public function get(Project $project): Project
    {
        try {
            return $project;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function getAll(Request $request): Collection
    {
        try {
            return Project::all();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function create(CreateProjectRequest $request): Project
    {
        try {
            return DB::transaction(function () use ($request) {
                $project = new Project;
                $project->fill($request->only($project->getFillable()));
                $project->save();

                return $project;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function update(UpdateProjectRequest $request, Project $project): Project
    {
        try {
            $project->fill($request->only($project->getFillable()));
            $project->save();

            return $project;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function delete(Project $project): bool
    {
        try {
            $project->attributes()->delete();
            $project->users()->detach();
            $project->timesheets()->delete();

            return $project->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }
}
