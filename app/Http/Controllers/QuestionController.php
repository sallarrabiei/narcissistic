<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\OptionType;
use App\Models\Survey;


class QuestionController extends Controller
{
    // public function edit(Question $question)
    // {
    //     $optionTypes = OptionType::all();
    //     return view('questions.edit', compact('question', 'optionTypes'));
    // }
    // public function edit($surveySlug, $questionId)
    // {
    //     $survey = Survey::where('slug', $surveySlug)->firstOrFail();
    //     $question = Question::findOrFail($questionId);

    //     return view('surveys.edit_question', compact('survey', 'question'));
    // }
    public function edit(Survey $survey, Question $question)
    {
        $optionTypes = OptionType::all();
        $tags = $survey->tags; // Fetch tags specific to the survey
        return view('surveys.edit_question', compact('survey', 'question', 'optionTypes', 'tags'));
    }

    public function update(Request $request, Survey $survey, Question $question)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'option_type_id' => 'required|exists:option_types,id',
        ]);

        $question->update($validated);

        // Update the tags relationship
        if ($request->has('tags')) {
            $question->tags()->sync($request->input('tags'));
        } else {
            $question->tags()->sync([]);
        }

        return redirect()->route('surveys.show', $survey->slug)->with('success', 'Question updated successfully.');
    }

    public function destroy(Survey $survey, Question $question)
    {
        // Ensure the question belongs to the survey
        if ($question->survey_id !== $survey->id) {
            abort(404);
        }

        $question->delete();

        return redirect()->route('surveys.show', $survey->slug)->with('success', 'Question deleted successfully.');
    }
}
