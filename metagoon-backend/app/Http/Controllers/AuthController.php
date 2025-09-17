<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname'  => 'required|string|max:50',
            'username'  => 'required|string|max:50|unique:users',
            'password'  => 'required|string|min:6',
            'gender'    => 'nullable|string',
            'age'       => 'nullable|integer|min:16',
            'role'      => 'required|in:bezdarbnieks,darbinieks,uzņēmējs',
            'company_number' => 'nullable|string|required_if:role,uzņēmējs',
            'company_address'=> 'nullable|string|required_if:role,uzņēmējs',
        ]);

        $user = User::create([
            'name' => $validated['firstname'].' '.$validated['lastname'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'gender'   => $validated['gender'] ?? null,
            'age'      => $validated['age'] ?? null,
            'role'     => $validated['role'],
            'company_number' => $validated['company_number'] ?? null,
            'company_address'=> $validated['company_address'] ?? null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Nepareizs lietotājvārds vai parole.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Atslēgts veiksmīgi']);
    }
}
