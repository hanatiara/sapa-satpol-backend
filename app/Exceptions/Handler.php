<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    public function render($request, Throwable $e)
{
    // If request expects JSON (like your API)
    if ($request->expectsJson()) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => config('app.debug') ? $e->getTrace() : [],
        ], 500);
    }

    return parent::render($request, $e);
}

}
