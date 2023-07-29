<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
            return false;
        });
    }

    public function render($request, Throwable $e)
    {
        // // Check ValidationException
        // if ($e instanceof ValidationException) {
        //     return $this->errorRespone(
        //         Response::HTTP_BAD_REQUEST,
        //         $e->validator->errors()
        //     );
        // }

        // // Check ValidationException
        // if ($e instanceof AuthenticationException) {
        //     return $this->errorRespone(
        //         Response::HTTP_UNAUTHORIZED,
        //         $e->getMessage()
        //     );
        // }

        // // Check ValidationException
        // if ($e instanceof AuthorizationException) {
        //     return $this->errorRespone(
        //         Response::HTTP_FORBIDDEN,
        //         $e->getMessage()
        //     );
        // }

        // // Check ValidationException
        // if ($e instanceof ErrorException) {
        //     return $this->errorRespone(
        //         Response::HTTP_BAD_REQUEST,
        //         $e->getMessage()
        //     );
        // }

        if ($e instanceof ErrorException) {
            return response()->json([
                'status' => $e->getCode(),
                'title' => 'Lỗi',
                'message' => $e->getMessage(),
            ]);
        }
        
        return parent::render($request, $e);
    }

    private function errorRespone($code, $message)
    {
        return response()->json([
            'success' => false,
            'code' => $code,
            'errors' => [
                'error_message' => $message,
            ],
        ], $code);
    }
}
