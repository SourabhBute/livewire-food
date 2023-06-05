<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler; 
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
 
 
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

          // This will throw a 404 / not found exception if we try to render a MethodNotAllowedHttpException (like if we do a GET on a POST url.
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            abort(404);
        });

   
    }
}
