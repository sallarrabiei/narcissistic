<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Survey;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Survey $survey)
    {
        $groups = $survey->groups;
        return view('groups.index', compact('survey', 'groups'));
    }

    public function create(Survey $survey)
    {
        return view('groups.create', compact('survey'));
    }

    public function store(Request $request, Survey $survey)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Group::create([
            'name' => $request->name,
            'survey_id' => $survey->id,
        ]);

        return redirect()->route('groups.index', $survey)->with('success', 'Group created successfully.');
    }
}
