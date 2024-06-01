<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:pending,accepted,spam',
        ]);

        $comment->update($request->all());

        return redirect()->route('comments.index')->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }

    public function accept(Comment $comment)
    {
        $comment->update(['status' => 'accepted']);
        return redirect()->route('comments.index')->with('success', 'Comment accepted.');
    }

    public function markAsSpam(Comment $comment)
    {
        $comment->update(['status' => 'spam']);
        return redirect()->route('comments.index')->with('success', 'Comment marked as spam.');
    }
}
