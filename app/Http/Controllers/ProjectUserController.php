<?php

namespace App\Http\Controllers;

use App\Contracts\ProjectUserServiceInterface;
use App\Http\Requests\ProjectUsers\CreateProjectUserRequest;
use App\Http\Requests\ProjectUsers\DeleteProjectUserRequest;
use App\Models\Project;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProjectUserController extends Controller
{
    public function __construct(
        private projectUserServiceInterface $projectUserService,
    ) {}

    public function get(Project $project): JsonResponse
    {
        try {
            /** @var Project $project */
            $project = $this->projectUserService->get($project);

            return response()->json([
                'message' => trans('Project users has been retrieved successfully!'),
                'data' => $project->toArray(),
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
            $data = $this->projectUserService->getAll($request);

            return response()->json([
                'message' => trans('Projects have been retrieved successfully!'),
                'data' => $data->toArray(),
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(CreateProjectUserRequest $request, Project $project): JsonResponse
    {
        try {
            /** @var Project $project */
            $project = $this->projectUserService->create($request, $project);

            return response()->json([
                'message' => trans('Project has been created successfully!'),
                'data' => $project->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(DeleteProjectUserRequest $request, Project $project): JsonResponse
    {
        try {
            $this->projectUserService->delete($request, $project);

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }
}
