<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use Exception;

class ScheduleHasSessionException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => 'Esta pauta já possui uma sessão aberta.',
        ], HttpStatusCodeEnum::CONFLICT);
    }
}
