<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use Firebase\JWT\JWT;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = Auth::attempt($credentials);

        if (!$attempt) {
            throw ValidationException::withMessages([
                'email' => 'Credentials does not match.'
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::user();
        $encryptedUser = Crypt::encryptString($user->id);

        $payload = [
            'iss' => 'http://localhost:3000',
            'sub' => $encryptedUser,
            'iat' => time(),
            'exp' => time() + 3600 * 24
        ];

        $token = JWT::encode($payload, env("JWT_SECRET"), "HS256");

        return response()->json(['success' => $attempt, 'token' => $token]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
