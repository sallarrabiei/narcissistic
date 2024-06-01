<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\OptionType;

class QuestionController extends Controller
{
    public function edit(Question $question)
    {
        $optionTypes = OptionType::all();
        return view('questions.edit', compact('question', 'optionTypes'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'option_type_id' => 'required|exists:option_types,id',
        ]);

        $question->update($request->all());

        return redirect()->route('surveys.show', $question->survey->slug)->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $surveySlug = $question->survey->slug;
        $question->delete();
        return redirect()->route('surveys.show', $surveySlug)->with('success', 'Question deleted successfully.');
    }
}
