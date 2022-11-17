<?php

namespace App\Exceptions;

use ErrorException;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\IniSizeFileException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        if ($exception instanceof ErrorException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Error Exception!'
            ], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Method not allowed!'
            ], 404);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Entry for ' . str_replace('App\\', '', $exception->getModel()) . ' not found'
            ], 404);
        }

        if ($exception instanceof RouteNotFoundException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Entry for not found!'
            ], 404);
        }
        if ($exception instanceof PostTooLargeException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Content seems to be too large!'
            ], 413);
        }
        if ($exception instanceof FileException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Content seems to be too large!'
            ], 413);
        }
        if ($exception instanceof IniSizeFileException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Content seems to be too large!'
            ], 413);
        }
        if ($exception instanceof QueryException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Content duplicate not supported here!'
            ], 413);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Authentication Error!'
            ], 413);
        }

        if ($exception instanceof RelationNotFoundException) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Issues fetching resource properties!'
            ], 500);
        }

        if ($exception instanceof FatalThrowableError) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'error' => $exception->getTraceAsString(),
                'message' => 'Server Error!'
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
