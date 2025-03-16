<?php

namespace App\Http\Controllers;

use App\Contracts\AttributeServiceInterface;
use App\Http\Requests\Attributes\CreateAttributeRequest;
use App\Http\Requests\Attributes\UpdateAttributeRequest;
use App\Models\Attribute;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AttributeController extends Controller
{
    public function __construct(
        private AttributeServiceInterface $attributeService,
    ) {}

    public function get(Attribute $attribute): JsonResponse
    {
        try {
            /** @var \App\Models\Attribute $attribute */
            $attribute = $this->attributeService->get($attribute);

            return response()->json([
                'message' => trans('Attribute has been retrieved successfully!'),
                'data' => $attribute->toArray(),
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
            $data = $this->attributeService->getAll($request);

            return response()->json([
                'message' => trans('Attributes have been retrieved successfully!'),
                'data' => $data->toArray(),
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(CreateAttributeRequest $request): JsonResponse
    {
        try {
            /** @var \App\Models\Attribute $attribute */
            $project = $this->attributeService->create($request);

            return response()->json([
                'message' => trans('Attribute has been created successfully!'),
                'data' => $project->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute): JsonResponse
    {
        try {
            /** @var \App\Models\Attribute $attribute */
            $attribute = $this->attributeService->update($request, $attribute);

            return response()->json([
                'message' => trans('Attribute has been updated successfully!'),
                'data' => $attribute->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(Attribute $attribute): JsonResponse
    {
        try {
            $this->attributeService->delete($attribute);

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }
}
