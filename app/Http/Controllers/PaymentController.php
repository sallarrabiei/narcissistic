<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Survey $survey)
    {
        // Redirect directly to the survey if the price is 0
        if ($survey->price == 0) {
            return redirect()->route('surveys.public.show', $survey->slug);
        }

        return view('payments.show', compact('survey'));
    }

    public function process(Request $request, Survey $survey)
    {
        // Implement your payment processing logic here

        // Mark the survey as paid for the user
        Auth::user()->payForSurvey($survey);

        return redirect()->route('surveys.public.show', $survey->slug)->with('success', 'Payment successful. You can now access the survey.');
    }
}
