<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use App\Models\OptionType;
use App\Models\Category;
use Illuminate\Support\Str;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'slug' => 'nullable|string|unique:surveys,slug',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $survey = Survey::create($data);
        $survey->categories()->sync($request->categories);

        return redirect()->route('surveys.index')->with('success', 'Survey created successfully.');
    }

    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        $categories = Category::all();
        return view('surveys.edit', compact('survey', 'categories'));
    }

    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'slug' => 'required|string|unique:surveys,slug,' . $survey->id,
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $survey->update($data);
        $survey->categories()->sync($request->categories);

        return redirect()->route('surveys.show', $survey)->with('success', 'Survey updated successfully.');
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
}
