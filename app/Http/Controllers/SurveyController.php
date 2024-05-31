<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $survey = Survey::create($request->all());

        return redirect()->route('surveys.index')->with('success', 'Survey created successfully.');
    }

    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }

    public function createQuestion(Survey $survey)
    {
        return view('surveys.create_question', compact('survey'));
    }

    public function storeQuestion(Request $request, Survey $survey)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $question = Question::create([
            'survey_id' => $survey->id,
            'text' => $request->text,
        ]);

        // Add default options for "Agree Disagree (5 Level)" question
        $options = [
            ['label' => 'Not at all like me', 'value' => 0],
            ['label' => 'Slightly like me', 'value' => 1],
            ['label' => 'Somewhat like me', 'value' => 2],
            ['label' => 'Moderately like me', 'value' => 3],
            ['label' => 'Quite a bit like me', 'value' => 4],
            ['label' => 'Very much like me', 'value' => 5],
        ];

        foreach ($options as $option) {
            Option::create([
                'question_id' => $question->id,
                'label' => $option['label'],
                'value' => $option['value'],
            ]);
        }

        return redirect()->route('surveys.show', $survey)->with('success', 'Question added successfully.');
    }
}
