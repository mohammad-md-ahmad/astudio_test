<?php

namespace App\Http\Controllers;

use App\Contracts\ProjectServiceInterface;
use App\Http\Requests\Projects\CreateProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Models\Project;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectServiceInterface $projectService,
    ) {}

    public function get(Project $project): JsonResponse
    {
        try {
            $data = $this->projectService->get($project);

            return response()->json([
                'message' => trans('Project has been retrieved successfully!'),
                'data' => $data->toArray(),
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            /** @var \Illuminate\Support\Collection $data */
            $data = $this->projectService->getAll($request);

            return response()->json([
                'message' => trans('Projects have been retrieved successfully!'),
                'data' => $data->toArray(),
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(CreateProjectRequest $request): JsonResponse
    {
        try {
            /** @var Project $project */
            $project = $this->projectService->create($request);

            return response()->json([
                'message' => trans('Project has been created successfully!'),
                'data' => $project->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        try {
            $project = $this->projectService->update($request, $project);

            return response()->json([
                'message' => trans('Project has been updated successfully!'),
                'data' => $project->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(Project $project): JsonResponse
    {
        try {
            $this->projectService->delete($project);

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }
}
