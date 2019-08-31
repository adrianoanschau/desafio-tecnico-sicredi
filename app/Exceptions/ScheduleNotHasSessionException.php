<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use Exception;

class ScheduleNotHasSessionException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => 'Esta pauta não possui uma sessão aberta.',
        ], HttpStatusCodeEnum::NOT_FOUND);
    }
}
