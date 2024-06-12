<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;
use App\Models\OptionType;

class OptionSeeder extends Seeder
{
    public function run()
    {
        $yesOrNo = OptionType::where('name', 'Yes or No')->first();
        Option::create(['option_type_id' => $yesOrNo->id, 'text' => 'Yes', 'value' => 1]);
        Option::create(['option_type_id' => $yesOrNo->id, 'text' => 'No', 'value' => 0]);

        $notAtAllToVeryMuch0To5 = OptionType::where('name', 'Not at all TO Very Much (0-5 score)')->first();
        Option::create(['option_type_id' => $notAtAllToVeryMuch0To5->id, 'text' => 'Not at all like me', 'value' => 0]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch0To5->id, 'text' => 'Slightly like me', 'value' => 1]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch0To5->id, 'text' => 'Somewhat like me', 'value' => 2]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch0To5->id, 'text' => 'Moderately like me', 'value' => 3]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch0To5->id, 'text' => 'Quite a bit like me', 'value' => 4]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch0To5->id, 'text' => 'Very much like me', 'value' => 5]);

        $notAtAllToVeryMuch1To6 = OptionType::where('name', 'Not at all TO Very Much (1-6 score)')->first();
        Option::create(['option_type_id' => $notAtAllToVeryMuch1To6->id, 'text' => 'Not at all like me', 'value' => 1]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch1To6->id, 'text' => 'Slightly like me', 'value' => 2]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch1To6->id, 'text' => 'Somewhat like me', 'value' => 3]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch1To6->id, 'text' => 'Moderately like me', 'value' => 4]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch1To6->id, 'text' => 'Quite a bit like me', 'value' => 5]);
        Option::create(['option_type_id' => $notAtAllToVeryMuch1To6->id, 'text' => 'Very much like me', 'value' => 6]);
    }
}

