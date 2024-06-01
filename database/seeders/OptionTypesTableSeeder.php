<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OptionType;

class OptionTypesTableSeeder extends Seeder
{
    public function run()
    {
        $optionTypes = [
            ['name' => 'Not at all TO Very Much (0-5 score)'],
            ['name' => 'Not at all TO Very Much (1-6 score)'],
            ['name' => 'Agree or Disagree'],
            ['name' => 'Yes or No'],
        ];

        foreach ($optionTypes as $type) {
            OptionType::create(['name' => $type]);
        }
    }
}
