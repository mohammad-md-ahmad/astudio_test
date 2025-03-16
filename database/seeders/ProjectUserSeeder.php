<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ProjectUser::updateOrCreate([
            'project_id' => Project::query()->first()->id,
            'user_id' => User::query()->first()->id,
        ]);
    }
}
