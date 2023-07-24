<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedHttpException ) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }elseif ($exception instanceof RouteNotFoundException) {
            return response()->json(['message' => 'Login to access the system'], 500);
        } elseif($exception->getStatusCode() === 403){
            return response()->json(['message' => 'Forbidden'], 403);
        }
        

        return parent::render($request, $exception);
    }
}