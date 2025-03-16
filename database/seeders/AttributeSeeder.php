<?php

namespace Database\Seeders;

use App\Enums\AttributeType;
use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attribute::updateOrCreate([
            'name' => 'department',
            'type' => AttributeType::Text->name,
        ]);
    }
}
