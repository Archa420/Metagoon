<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacanciesController extends Controller
{
    // List all vacancies
    public function index()
    {
        $vacancies = JobVacancy::with('user')->latest()->get();

        $vacancies->transform(function ($vacancy) {
            $vacancy->logo_url = $vacancy->logo ? asset("storage/{$vacancy->logo}") : null;
            return $vacancy;
        });

        return response()->json($vacancies);
    }

    // Fetch single vacancy
    public function show($id)
    {
        $vacancy = JobVacancy::with('user')->find($id);

        if (!$vacancy) {
            return response()->json(['message' => 'Vacancy not found'], 404);
        }

        $vacancy->logo_url = $vacancy->logo ? asset("storage/{$vacancy->logo}") : null;

        return response()->json($vacancy);
    }

    // Create a vacancy
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) return response()->json(['message' => 'Unauthenticated'], 401);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'salary'      => 'required|string|max:255',
            'description' => 'required|string',
            'logo'        => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = $user->id;
        $validated['company'] = $user->company_name ?? ($request->input('company') ?? 'Nezināms uzņēmums');

        $vacancy = JobVacancy::create($validated);
        $vacancy->logo_url = $vacancy->logo ? asset("storage/{$vacancy->logo}") : null;

        return response()->json($vacancy, 201);
    }

    // Delete vacancy
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $vacancy = JobVacancy::find($id);

        if (!$vacancy) return response()->json(['message' => 'Vacancy not found'], 404);

        if ($vacancy->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($vacancy->logo && \Storage::disk('public')->exists($vacancy->logo)) {
            \Storage::disk('public')->delete($vacancy->logo);
        }

        $vacancy->delete();

        return response()->json(['message' => 'Vacancy deleted successfully']);
    }

    // Upload logo
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('file')->store('vacancy_logos', 'public');

        return response()->json(['path' => $path]);
    }
}
