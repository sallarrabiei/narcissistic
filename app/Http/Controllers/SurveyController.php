<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Response;
use App\Models\Question;
use App\Models\Option;
use App\Models\OptionType;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\SurveyResult;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

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

        // Fetch questions with options
        $questions = $survey->questions()->with('options')->get();

        // Debug statement to check loaded questions and options
        // dd($questions);

        return view('surveys.show', compact('survey', 'questions'));
    }
//     public function showQuestions(Survey $survey)
// {
//     $questions = $survey->questions()->with('options')->get();
//     return view('surveys.public_questions', compact('survey', 'questions'));
// }

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
        $groups = $survey->groups; // Get groups associated with the survey

        return view('surveys.create_question', compact('survey', 'optionTypes', 'groups'));
    }

    public function storeQuestion(Request $request, Survey $survey)
{
    $request->validate([
        'text' => 'required|string|max:255',
        'option_type_id' => 'nullable|exists:option_types,id',
        'options' => 'nullable|array',
        'options.*.label' => 'required_with:options|string',
        'options.*.value' => 'required_with:options|integer',
        'group_id' => 'required|exists:groups,id', // Ensure group_id is validated
    ]);

    $question = new Question([
        'text' => $request->text,
        'survey_id' => $survey->id,
        'option_type_id' => $request->option_type_id,
        'group_id' => $request->group_id, // Set group_id
    ]);
    $question->save();

    if ($request->has('options')) {
        $options = $request->input('options', []);
        foreach ($options as $option) {
            Option::create([
                'question_id' => $question->id,
                'option_type_id' => $question->option_type_id,
                'label' => $option['label'],
                'value' => $option['value'],
            ]);
        }
    }

    return redirect()->route('surveys.show', $survey->slug)->with('success', 'Question created successfully.');
}




public function editQuestion(Survey $survey, $questionId)
{
    $question = Question::with('options')->findOrFail($questionId);
    $optionTypes = OptionType::all();
    $groups = $survey->groups; // Get groups associated with the survey

    return view('surveys.edit_question', compact('survey', 'question', 'optionTypes', 'groups'));
}


    public function updateQuestion(Request $request, Survey $survey, $questionId)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'option_type_id' => 'nullable|exists:option_types,id',
            'options' => 'nullable|array',
            'options.*.label' => 'required_with:options|string',
            'options.*.value' => 'required_with:options|integer',
            'group_id' => 'required|exists:groups,id', // Ensure group_id is validated
        ]);

        $question = Question::findOrFail($questionId);
        $question->update([
            'text' => $request->text,
            'option_type_id' => $request->option_type_id,
            'group_id' => $request->group_id, // Set group_id
        ]);

        // Handle options
        $question->options()->delete(); // Delete existing options
        if ($request->has('options')) {
            $options = $request->input('options', []);
            foreach ($options as $option) {
                Option::create([
                    'question_id' => $question->id,
                    'option_type_id' => $question->option_type_id,
                    'label' => $option['label'],
                    'value' => $option['value'],
                ]);
            }
        }

        return redirect()->route('surveys.show', $survey->slug)->with('success', 'Question updated successfully.');
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


    // public function submitSurvey(Request $request, $slug)
    // {
    //     $survey = Survey::where('slug', $slug)->firstOrFail();
    //     $questions = $survey->questions()->get();
    //     $responses = $request->input('responses', []);

    //     $score = 0;
    //     foreach ($questions as $question) {
    //         if (isset($responses[$question->id])) {
    //             $score += (int) $responses[$question->id];
    //         }
    //     }

    //     // Save the result to the database
    //     SurveyResult::create([
    //         'user_id' => Auth::id(),
    //         'survey_id' => $survey->id,
    //         'responses' => $responses,
    //         'score' => $score,
    //     ]);

    //     // Calculate average score and total participants
    //     $results = SurveyResult::where('survey_id', $survey->id)->get();
    //     $averageScore = $results->avg('score');
    //     $totalParticipants = $results->count();

    //     // Decode analysis conditions
    //     $analysisConditions = json_decode($survey->analysis_conditions, true);

    //     return view('surveys.public_result', compact('survey', 'score', 'averageScore', 'totalParticipants', 'analysisConditions'));
    // }

    public function showAnalysis($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $results = SurveyResult::where('survey_id', $survey->id)->get();

        $averageScore = $results->avg('score');
        $totalParticipants = $results->count();

        return view('surveys.analysis', compact('survey', 'averageScore', 'totalParticipants'));
    }

    public function calculateAverageScores(Survey $survey)
    {
        $tags = $survey->tags;
        $averageScores = [];

        foreach ($tags as $tag) {
            $questions = $tag->questions()->where('survey_id', $survey->id)->get();
            $totalScore = 0;
            $responseCount = 0;

            foreach ($questions as $question) {
                $responses = $question->responses;
                $responseCount += $responses->count();
                $totalScore += $responses->sum('value');
            }

            if ($responseCount > 0) {
                $averageScores[$tag->name] = $totalScore / $responseCount;

            } else {
                $averageScores[$tag->name] = 0;
            }
        }

        return $averageScores;
    }

    // Handle survey submission
    public function submitSurvey(Request $request, Survey $survey)
{
    $score = 0;
    $responses = $request->input('responses', []);

    // Calculate the score based on responses
    foreach ($responses as $response) {
        $score += $response;
    }

    // Retrieve the analysis text
    $analysisText = $survey->analysis_text;

    // Calculate average scores by group
    $averageScores = [];
    foreach ($survey->groups as $group) {
        $groupQuestions = $group->questions;
        $groupScoreSum = 0;
        $groupQuestionCount = $groupQuestions->count();

        if ($groupQuestionCount > 0) {
            foreach ($groupQuestions as $question) {
                $groupScoreSum += $responses[$question->id] ?? 0;
            }
            $averageScores[$group->name] = $groupScoreSum / $groupQuestionCount;
            $averageScores[$group->name] = round($groupScoreSum / $groupQuestionCount, 1);

        }
    }

    return view('surveys.public_result', compact('survey', 'score', 'analysisText', 'averageScores'));
}


}
