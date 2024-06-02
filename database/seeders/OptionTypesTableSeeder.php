<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('option_types')->insert([
            ['name' => 'Agree Disagree (5 Level)'],
            ['name' => 'Not at all TO Very Much (0-5 score)'],
            ['name' => 'Not at all TO Very Much (1-6 score)'],
            ['name' => 'Agree or Disagree'],
            ['name' => 'Yes or No'],
        ]);
    }
}
