<?php

namespace Infinitypaul\Cbs;

use Exception;

class Exceptions extends Exception
{
    private static $_errors = [
        'format.null_mode'          => 'The specified mode is null. Please use either live or staging',
        'format.invalid_currency_code' => 'The specified currency code is invalid. Please use ISO 4217 notation (e.g. USD).',
        'format.unsupported_currency'  => 'The specified currency code is not currently supported.',
        'format.unsupported_type'      => 'The Specified Types Is Currently Not Supported',
        'format.is_null'      => 'The Access Token can not be null. Please pass it to the constructor',
    ];

    public static function create($message): Exceptions
    {
        return new static(self::$_errors[$message]);
    }
}
