<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AttributeServiceInterface;
use App\Contracts\ProjectServiceInterface;
use App\Http\Requests\Attributes\SetAttributeValueRequest;
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
    public function __construct(
        protected AttributeServiceInterface $attributeService,
    ) {}

    public function get(Project $project): Project
    {
        try {
            return $project->load('attributes');
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

                if ($request->has('attributes')) {
                    $this->setAttributeValues($project, $request->input('attributes'));
                }

                return $project->load('attributes');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function update(UpdateProjectRequest $request, Project $project): Project
    {
        try {
            return DB::transaction(function () use ($request, $project) {
                $project->fill($request->only($project->getFillable()));
                $project->save();

                if ($request->has('attributes')) {
                    $this->setAttributeValues($project, $request->input('attributes'));
                }

                return $project->load('attributes');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function delete(Project $project): bool
    {
        try {
            return DB::transaction(function () use ($project) {
                $project->attributes()->delete();
                $project->users()->detach();
                $project->timesheets()->delete();

                return $project->delete();
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    private function setAttributeValues(Project $project, array $attributes): void
    {
        try {
            foreach ($attributes as $attributeName => $value) {
                $setAttributeValueRequest = new SetAttributeValueRequest;
                $setAttributeValueRequest->merge([
                    'name' => $attributeName,
                    'value' => $value,
                    'entity_id' => $project->id,
                    'entity_type' => get_class($project),
                ]);

                $this->attributeService->setAttributeValue($setAttributeValueRequest);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }
}
