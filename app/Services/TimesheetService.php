<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\TimesheetServiceInterface;
use App\Http\Requests\Timesheets\CreateTimesheetRequest;
use App\Http\Requests\Timesheets\UpdateTimesheetRequest;
use App\Models\Timesheet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimesheetService implements TimesheetServiceInterface
{
    public function get(Timesheet $timesheet): Timesheet
    {
        try {
            return $timesheet;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function getAll(Request $request): Collection
    {
        try {
            return Timesheet::all();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function create(CreateTimesheetRequest $request): Timesheet
    {
        try {
            return DB::transaction(function () use ($request) {
                $timesheet = new Timesheet;
                $timesheet->fill($request->only($timesheet->getFillable()));
                $timesheet->save();

                return $timesheet;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function update(UpdateTimesheetRequest $request, Timesheet $timesheet): Timesheet
    {
        try {
            $timesheet->fill($request->only($timesheet->getFillable()));
            $timesheet->save();

            return $timesheet;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }

    public function delete(Timesheet $timesheet): bool
    {
        try {
            return $timesheet->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw $e;
        }
    }
}
