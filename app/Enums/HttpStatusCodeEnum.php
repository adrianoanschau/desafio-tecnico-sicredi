<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class HttpStatusCodeEnum extends Enum
{
    const SUCCESS       = 200;
    const CREATED       = 201;
    const NO_CONTENT    = 204;

    const BAD_REQUEST   = 400;
    const NOT_FOUND     = 404;
    const CONFLICT      = 409;

    const INTERNAL_SERVER_ERROR = 500;
}
