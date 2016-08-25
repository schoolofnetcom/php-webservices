<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $arrayException = [
            HttpException::class,
            ModelNotFoundException::class,
            ValidationException::class
        ];
        if(in_array(get_class($e),$arrayException)){
            $response = parent::render($request, $e);
            $arrayError = [
                'status_code' => $response->getStatusCode(),
                'error_code' => 5557,
                'message' => $e->getMessage(),
                'about_error' => 'algum link'
            ];
            if($e instanceof ValidationException){
                $arrayError['fields'] = $e->validator->getMessageBag()->toArray();
            }
            return son_response()->make($arrayError,$response->getStatusCode());
        }
        return parent::render($request, $e);
    }
}
