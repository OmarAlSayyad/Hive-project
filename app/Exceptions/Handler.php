<?php

    namespace App\Exceptions;

    use Illuminate\Auth\Access\AuthorizationException;
    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Throwable;

    class Handler extends ExceptionHandler
    {
        protected $dontReport = [
            AuthorizationException::class,
        ];


        public function render($request, Throwable $e)
        {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 403);
            }

            return parent::render($request, $e);
        }

    }

