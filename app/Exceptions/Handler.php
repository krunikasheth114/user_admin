<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
            //
        });
    }

    public function render($request, Throwable $exception)
    {
       
        if ($request->expectsJson()) {
            if ($exception instanceof ValidationException) {
                $transformed = [];

                foreach ($exception->errors() as $field => $message) {
                    $transformed[$field] = $message[0];
                }
                return response()->json([
                    'errors' => $transformed,
                ], 422);
            }
            if ($exception instanceof AccessDeniedHttpException || $exception instanceof AuthorizationException) {
               
                return response()->json([
                    'success' => false,
                    'errors' => new \StdClass(),
                    'message' => $exception->getMessage(),
                ], 403);
            }

            if ($exception instanceof MethodNotAllowedHttpException || $exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
         
                return response()->json([
                    'success' => false,
                    'errors' => new \StdClass(),
                    'message' => 'URl/Method/Model Not Found.',
                ], 404);
            }
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $e)
    {
        if ($request->expectsJson()) {
            $header_token = $request->server('REDIRECT_HTTP_AUTHORIZATION');
            if ($header_token) {
                $token = '';
                if (Str::startsWith($header_token, 'Bearer ')) {
                    $token = Str::substr($header_token, 7);
                }
                if ($token) {
                    $tokenParts = explode(".", $token);
                    if (!empty($tokenParts[0]) and !empty($tokenParts[1])) {
                        $tokenHeader = base64_decode($tokenParts[0]);
                        $tokenPayload = base64_decode($tokenParts[1]);
                        $jwtHeader = json_decode($tokenHeader);
                        $jwtPayload = json_decode($tokenPayload);
                    } else {
                        $jwtPayload = null;
                    }

                    if ($jwtPayload) {
                        $access_token = AccessToken::where('id', $jwtPayload->jti)->where('revoked', 0)->first();
                        $user = User::find($jwtPayload->sub);
                        if ($access_token and $user->authToken == $token) {
                            return response()->json([
                                'message' => 'Unauthenticated ! Your session has been expired, Please Login First.',
                                'isExpired' => true
                            ], 401);
                        } else {
                            return response()->json([
                                'message' => 'Unauthenticated ! Your session has been expired, Please Login First.',
                            ], 401);
                        }
                    } else {
                        return response()->json([
                            'message' => 'Unauthenticated ! Your session has been expired, Please Login First.',
                        ], 401);
                    }
                }
            } else {
                return response()->json([
                    'message' => 'Unauthenticated ! Your session has been expired, Please Login First.',
                ], 401);
            }
        } else {
            return redirect()->guest('user/login');
        }
    }
}
