<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttributeValue::updateOrCreate([
            'attribute_id' => Attribute::query()->first()->id,
            'entity_id' => Project::query()->first()->id,
            'entity_type' => Project::class,
        ], [
            'value' => 'Tech',
        ]);
    }
}
