<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use App\Models\OptionType;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\SurveyResult;
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
        $categories = Category::all();
        return view('surveys.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['analysis_conditions'] = isset($data['conditions']) ? json_encode($data['conditions']) : json_encode([]);
        $survey = Survey::create($data);
        $survey->categories()->sync($request->categories);

        return redirect()->route('surveys.index')->with('success', 'Survey created successfully');
    }

    public function show(Survey $survey)
    {
        if ($survey->price && !Auth::user()->isSuperAdmin()) {
            // Check if the user has paid for the survey
            if (!Auth::user() || !Auth::user()->hasPaidForSurvey($survey)) {
                return redirect()->route('payment.show', $survey->id)->with('error', 'You need to pay to access this survey.');
            }
        }

        return view('surveys.show', compact('survey'));
    }

    public function edit($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $survey->analysis_conditions = json_decode($survey->analysis_conditions, true);
        $categories = Category::all();
        return view('surveys.edit', compact('survey', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $data = $request->all();
        $data['analysis_conditions'] = isset($data['conditions']) ? json_encode($data['conditions']) : json_encode([]);
        $survey->update($data);
        $survey->categories()->sync($request->categories);

        return redirect()->route('surveys.edit', $survey->slug)->with('success', 'Survey updated successfully');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('success', 'Survey deleted successfully.');
    }

    public function createQuestion(Survey $survey)
    {
        $optionTypes = OptionType::all();
        return view('surveys.create_question', compact('survey', 'optionTypes'));
    }

    public function storeQuestion(Request $request, Survey $survey)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'option_type_id' => 'required|exists:option_types,id',
        ]);

        $question = Question::create([
            'survey_id' => $survey->id,
            'text' => $request->text,
            'option_type_id' => $request->option_type_id,
        ]);

        $this->addOptions($question);

        return redirect()->route('surveys.show', $survey)->with('success', 'Question added successfully.');
    }

    private function addOptions(Question $question)
    {
        $options = [];

        if ($question->optionType->name === 'Not at all TO Very Much (0-5 score)') {
            $options = [
                ['label' => 'Not at all like me', 'value' => 0],
                ['label' => 'Slightly like me', 'value' => 1],
                ['label' => 'Somewhat like me', 'value' => 2],
                ['label' => 'Moderately like me', 'value' => 3],
                ['label' => 'Quite a bit like me', 'value' => 4],
                ['label' => 'Very much like me', 'value' => 5],
            ];
        } elseif ($question->optionType->name === 'Not at all TO Very Much (1-6 score)') {
            $options = [
                ['label' => 'Not at all like me', 'value' => 1],
                ['label' => 'Slightly like me', 'value' => 2],
                ['label' => 'Somewhat like me', 'value' => 3],
                ['label' => 'Moderately like me', 'value' => 4],
                ['label' => 'Quite a bit like me', 'value' => 5],
                ['label' => 'Very much like me', 'value' => 6],
            ];
        } elseif ($question->optionType->name === 'Agree or Disagree') {
            $options = [
                ['label' => 'Agree', 'value' => 1],
                ['label' => 'Disagree', 'value' => 2],
            ];
        } elseif ($question->optionType->name === 'Yes or No') {
            $options = [
                ['label' => 'Yes', 'value' => 1],
                ['label' => 'No', 'value' => 2],
            ];
        }

        foreach ($options as $option) {
            Option::create([
                'question_id' => $question->id,
                'option_type_id' => $question->option_type_id,
                'label' => $option['label'],
                'value' => $option['value'],
            ]);
        }
    }
    public function showPublic($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();

        if ($survey->price > 0 && (!Auth::check() || !Auth::user()->isSuperAdmin())) {
            // Check if the user has paid for the survey
            if (!Auth::check() || !Auth::user()->hasPaidForSurvey($survey)) {
                return redirect()->route('payment.show', $survey->id)->with('error', 'You need to pay to access this survey.');
            }
        }

        $questions = $survey->questions()->with('options')->get();

        return view('surveys.public_show', compact('survey', 'questions'));
    }
    public function startSurvey($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        return view('surveys.public_show', compact('survey'));
    }

    public function showQuestion(Request $request, $slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $questions = $survey->questions()->get();

        $currentIndex = $request->get('index', 0);
        if ($currentIndex < 0 || $currentIndex >= count($questions)) {
            $currentIndex = 0;
        }

        $currentQuestion = $questions[$currentIndex];
        $responses = $request->input('responses', []);

        return view('surveys.public_questions', compact('survey', 'currentQuestion', 'currentIndex', 'responses'));
    }

    public function submitSurvey(Request $request, $slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $questions = $survey->questions()->get();
        $responses = $request->input('responses', []);

        $score = 0;
        foreach ($questions as $question) {
            if (isset($responses[$question->id])) {
                $score += (int) $responses[$question->id];
            }
        }

        // Save the result to the database
        SurveyResult::create([
            'user_id' => Auth::id(),
            'survey_id' => $survey->id,
            'responses' => $responses,
            'score' => $score,
        ]);

        // Calculate average score and total participants
        $results = SurveyResult::where('survey_id', $survey->id)->get();
        $averageScore = $results->avg('score');
        $totalParticipants = $results->count();

        // Decode analysis conditions
        $analysisConditions = json_decode($survey->analysis_conditions, true);

        return view('surveys.public_result', compact('survey', 'score', 'averageScore', 'totalParticipants', 'analysisConditions'));
    }

    public function showAnalysis($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $results = SurveyResult::where('survey_id', $survey->id)->get();

        $averageScore = $results->avg('score');
        $totalParticipants = $results->count();

        return view('surveys.analysis', compact('survey', 'averageScore', 'totalParticipants'));
    }


}
