<?php

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use Exception;

class UniqueDocumentAssociateException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => trans('exceptions.System Existing Document'),
        ], HttpStatusCodeEnum::FORBIDDEN);
    }
}
