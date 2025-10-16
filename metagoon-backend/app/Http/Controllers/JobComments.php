<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;

class JobComments extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $validated = $request->validate([
            'comment_text' => 'required|string|max:1000',
            'vacancy_id'   => 'required|exists:job_vacancies,id',
        ]);

        $validated['user_id'] = $user->id;

        $comment = Comments::create($validated);

        return response()->json($comment, 201);
    }

    public function index($vacancyId)
    {
        $comments = Comments::with('user')
            ->where('vacancy_id', $vacancyId)
            ->latest()
            ->get();

        return response()->json($comments);
    }
}
