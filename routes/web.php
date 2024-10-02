<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

Route::get('/csrf_token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::controller(RegisterController::class)->group(function() {
    Route::post("/register", "store");
});

Route::controller(SessionController::class)->group(function() {
    Route::get("/check_auth", "verify");
    Route::post("/login", "store");
});

Route::middleware("auth")->group(function() {
    Route::get('/email/verify', function () {
        return response()->json(['success' => true]);
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect("http://localhost:3000/login");
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Email verification sent!']);
    })->middleware([ 'throttle:6,1'])->name('verification.send');
});
