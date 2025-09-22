<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacanciesController extends Controller
{
    public function index()
    {
        $vacancies = JobVacancy::with('user')->latest()->get();

        // Build full URL for frontend
        $vacancies->transform(function ($vacancy) {
            // Assuming images are in public/images
            $vacancy->logo_url = $vacancy->logo 
                ? asset("images/{$vacancy->logo}") 
                : null;
            return $vacancy;
        });

        return response()->json($vacancies);
    }

    public function store(Request $request)
    {
        $authUser = $request->user();
        if (!$authUser) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'salary'      => 'required|string|max:255',
            'description' => 'required|string',
            'logo'        => 'nullable|string|max:255', // just filename
        ]);

        $validated['user_id'] = $authUser->id;
        $validated['company'] = $authUser->company ?? ($request->input('company') ?? 'Nezināms uzņēmums');

        $vacancy = JobVacancy::create($validated);
        $vacancy->logo_url = $vacancy->logo 
            ? asset("images/{$vacancy->logo}") 
            : null;

        return response()->json($vacancy, 201);
    }
}
