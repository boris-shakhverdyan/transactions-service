<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Responses\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $exception, Request $request) {
            if ($request->is("api/*")) {
                $message = trim($exception->getMessage());
                $message = empty($message) ? "Unknown error" : $message;

                $errors = method_exists($exception, "errors") ? $exception->errors() : [];

                $statusCode = match (true) {
                    method_exists($exception, "getStatusCode") => $exception->getStatusCode(),
                    $exception instanceof ValidationException => Response::HTTP_UNPROCESSABLE_ENTITY,
                    $exception instanceof AuthenticationException => Response::HTTP_UNAUTHORIZED,
                    $exception instanceof ThrottleRequestsException => Response::HTTP_TOO_MANY_REQUESTS,
                    $exception instanceof InvalidArgumentException => Response::HTTP_BAD_REQUEST,
                    default => Response::HTTP_INTERNAL_SERVER_ERROR,
                };

                return ApiResponse::error($message, $statusCode, $errors);
            }
        });
    })->create();
