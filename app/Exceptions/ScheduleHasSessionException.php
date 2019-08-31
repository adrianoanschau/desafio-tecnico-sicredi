<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use Exception;

class ScheduleHasSessionException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => trans('exceptions.This staff already has an open section'),
        ], HttpStatusCodeEnum::CONFLICT);
    }
}
