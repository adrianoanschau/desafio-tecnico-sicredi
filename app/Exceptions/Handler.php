<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if (
            $exception instanceof ScheduleHasSessionException
            || $exception instanceof ScheduleNotHasSessionException
            || $exception instanceof InvalidVoteOptionException
            || $exception instanceof ScheduleSessionIsClosedException
            || $exception instanceof UniqueVotePerSessionException
            || $exception instanceof UniqueDocumentAssociateException
        ) {
            return $exception->render($request);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'message' => trans('exceptions.Resource not found'),
            ], HttpStatusCodeEnum::NOT_FOUND);
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => trans('exceptions.Validation error on uploaded data'),
                'errors' => $exception->validator->errors(),
            ], HttpStatusCodeEnum::BAD_REQUEST);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Rota inválida'
            ], HttpStatusCodeEnum::NOT_FOUND);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'message' => 'Método inválido para esta rota'
            ], HttpStatusCodeEnum::METHOD_NOT_ALLOWED);
        }

        return response()->json([
            'message' => trans('exceptions.Unknown error')
        ], HttpStatusCodeEnum::INTERNAL_SERVER_ERROR);
    }
}
