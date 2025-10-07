<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationsController extends Controller
{
    // Apply for a vacancy
    public function apply(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) return response()->json(['message' => 'Unauthenticated'], 401);

        $vacancy = JobVacancy::find($id);
        if (!$vacancy) return response()->json(['message' => 'Vacancy not found'], 404);

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $cv_path = null;
        if ($request->hasFile('cv')) {
            $cv_path = $request->file('cv')->store('cvs', 'public');
        }

        $application = JobApplication::create([
            'vacancy_id' => $vacancy->id,
            'user_id' => $user->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'cv_path' => $cv_path,
        ]);

        return response()->json(['message' => 'Application submitted', 'application' => $application], 201);
    }

    // Employer view: all applications across their vacancies
    public function employerApplications(Request $request)
    {
        $user = $request->user();

        $applications = JobApplication::whereHas('vacancy', fn($q) => $q->where('user_id', $user->id))
            ->with(['vacancy:id,title', 'user:id,name,email'])
            ->latest()
            ->get();

        return response()->json($applications);
    }
}
