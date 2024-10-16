<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
    ];

    protected $dontFlash = [];

    public function register()
    {
        $this->renderable(function (Throwable $exception) {
            if ($exception instanceof AuthenticationException && !is_null($exception->redirectTo())) {
                return null;
            }

            $errors = [];
//            dd($exception);
            switch (get_class($exception)) {
                case JWTException::class:
                case TokenExpiredException::class:
                case AuthenticationException::class:
                case TokenInvalidException::class:
                case TokenBlacklistedException::class:
                case UnauthorizedHttpException::class:
                    $statusCode = 401;
                    $message    = 'unauthenticated';
                    $errors[]   = compact('message');

                    break;
                case NotFoundHttpException::class:
                    $statusCode = 404;
                    $message    = 'notFound';
                    $errors[]   = compact('message');

                    break;
                case MethodNotAllowedHttpException::class:
                    $statusCode = 405;
                    $message    = 'methodNotAllowed';
                    $errors[]   = compact('message');

                    break;
                case ValidationException::class:
                    /** @var ValidationException $exception */
                    $statusCode = 422;

                    foreach ($exception->errors() as $field => $messages) {
                        foreach ($messages as $message) {
                            $errors[] = compact('field', 'message');
                        }
                    }

                    break;
                case ThrottleRequestsException::class:
                    $statusCode = 429;
                    $message    = 'tooManyAttempts';
                    $errors[]   = compact('message');

                    break;

                default:
                    $statusCode = 500;
                    $message    = 'unknownError';
                    $errors[]   = compact('message');

                    break;
            }

            if ($exception instanceof SymfonyHttpException && App::isDownForMaintenance()) {
                $statusCode = 503;
                $message    = 'IN MAINTENANCE';
                $errors     = [compact('message')];
            }

            if (env('APP_DEBUG')) {
                $errors['moreInfo'] = [
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                ];
            }

            $response = compact('errors');

            return response()->json($response, $statusCode);
        });
    }
}
