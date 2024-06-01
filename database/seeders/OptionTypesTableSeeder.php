<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OptionType;

class OptionTypesTableSeeder extends Seeder
{
    public function run()
    {
        $optionTypes = [
            'Not at all TO Very Much (0-5 score)',
            'Not at all TO Very Much (1-6 score)',
        ];

        foreach ($optionTypes as $type) {
            OptionType::create(['name' => $type]);
        }
    }
}
