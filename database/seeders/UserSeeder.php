<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'mohammad@astudio.com',
        ], [
            'first_name' => 'Mohammad',
            'last_name' => 'Ahmad',
            'password' => Hash::make('P@$$w0rdrand'),
        ]);
    }
}
