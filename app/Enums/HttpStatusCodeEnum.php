<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class HttpStatusCodeEnum extends Enum
{
    const SUCCESS       = 200;
    const CREATED       = 201;
    const NO_CONTENT    = 204;

    const NOT_FOUND     = 404;
    const CONFLICT      = 409;

    const INTERNAL_SERVER_ERROR = 500;
}
