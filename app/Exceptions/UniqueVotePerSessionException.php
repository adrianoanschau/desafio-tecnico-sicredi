<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use Exception;

class UniqueVotePerSessionException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => trans('exceptions.You already voted for this session'),
        ], HttpStatusCodeEnum::FORBIDDEN);
    }
}
