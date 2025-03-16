<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\Timesheets\CreateTimesheetRequest;
use App\Http\Requests\Timesheets\UpdateTimesheetRequest;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface TimesheetServiceInterface
{
    public function get(Timesheet $timesheet): Timesheet;

    public function getAll(Request $request): Collection;

    public function create(CreateTimesheetRequest $request): Timesheet;

    public function update(UpdateTimesheetRequest $request, Timesheet $timesheet): Timesheet;

    public function delete(Timesheet $timesheet): bool;
}
