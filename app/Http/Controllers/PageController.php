<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('pages.index', compact('pages'));
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'feature_image' => 'nullable|image',
            'content' => 'required|string',
            'reading_time' => 'nullable|integer',
            'enable_comment' => 'boolean',
            'meta_description' => 'nullable|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug',
        ]);

        $data = $request->all();

        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store('images', 'public');
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['enable_comment'] = $request->has('enable_comment');

        Page::create($data);

        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'feature_image' => 'nullable|image',
            'content' => 'required|string',
            'reading_time' => 'nullable|integer',
            'enable_comment' => 'boolean',
            'meta_description' => 'nullable|string|max:255',
            'slug' => 'required|string|unique:pages,slug,' . $page->id,
        ]);

        $data = $request->all();

        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store('images', 'public');
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['enable_comment'] = $request->has('enable_comment');

        $page->update($data);

        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('page'));
    }

    public function storeComment(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page->comments()->create($request->all());

        return redirect()->route('pages.show', $page->slug)->with('success', 'Comment added successfully.');
    }

}

