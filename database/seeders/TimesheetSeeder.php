<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Timesheet::updateOrCreate([
            'project_id' => Project::query()->first()->id,
            'user_id' => User::query()->first()->id,
        ], [
            'task_name' => 'Task 1',
            'date' => Carbon::now(),
            'hours' => 5.5,
        ]);
    }
}
