<?php


namespace Infinitypaul\Cbs;

/**
 *
 * @method mixed addBody($name, $value);
 */
class CbsCall
{
    public static function service(): InvoiceService
    {
        return new InvoiceService();
    }

    public static function __callStatic($method, $arguments)
    {
        return self::service()->{$method}(...$arguments);
    }
}
