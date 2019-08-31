<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use Exception;

class InvalidVoteOptionException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => trans('exceptions.Invalid voting option. (allowed options: \'Y\' and \'N\')'),
        ], HttpStatusCodeEnum::BAD_REQUEST);
    }
}
