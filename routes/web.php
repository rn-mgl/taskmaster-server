<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get("/login", function() {
    return "";
})->name("login");

Route::get('/csrf_token', function () {

    logger(Auth::check() ? "Yes" : "no");

    return response()->json(['csrf_token' => csrf_token()]);
});

Route::controller(RegisterController::class)->group(function() {
    Route::post("/register", "store");
});

Route::middleware("auth")->group(function() {
    Route::get('/email/verify', function () {
        return response()->json(['success' => true]);
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        logger("is verified");

        return response()->json(['success' => true]);
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Email verification sent!']);
    })->middleware([ 'throttle:6,1'])->name('verification.send');
});
