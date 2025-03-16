<?php

namespace App\Http\Controllers;

use App\Contracts\TimesheetServiceInterface;
use App\Http\Requests\Timesheets\CreateTimesheetRequest;
use App\Http\Requests\Timesheets\UpdateTimesheetRequest;
use App\Models\Timesheet;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TimesheetController extends Controller
{
    public function __construct(
        private TimesheetServiceInterface $timesheetService,
    ) {}

    public function get(Timesheet $timesheet): JsonResponse
    {
        try {
            /** @var Timesheet $timesheet */
            $timesheet = $this->timesheetService->get($timesheet);

            return response()->json([
                'message' => trans('Timesheet has been retrieved successfully!'),
                'data' => $timesheet->toArray(),
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
            $data = $this->timesheetService->getAll($request);

            return response()->json([
                'message' => trans('Timesheets have been retrieved successfully!'),
                'data' => $data->toArray(),
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(CreateTimesheetRequest $request): JsonResponse
    {
        try {
            /** @var Timesheet $timesheet */
            $timesheet = $this->timesheetService->create($request);

            return response()->json([
                'message' => trans('Timesheet has been created successfully!'),
                'data' => $timesheet->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateTimesheetRequest $request, Timesheet $timesheet): JsonResponse
    {
        try {
            /** @var Timesheet $timesheet */
            $timesheet = $this->timesheetService->update($request, $timesheet);

            return response()->json([
                'message' => trans('Timesheet has been updated successfully!'),
                'data' => $timesheet->toArray(),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(Timesheet $timesheet): JsonResponse
    {
        try {
            $this->timesheetService->delete($timesheet);

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return response()->json(['message' => trans('An error occurred!')], Response::HTTP_BAD_REQUEST);
        }
    }
}
