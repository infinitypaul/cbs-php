<?php

namespace Infinitypaul\Cbs;

class Cbs
{
    public static $BaseUrl;

    public static $secretKey;

    public static $clientId;

    public static function setup(array $url, $secretKey, $clientId, $mode = 'live')
    {
        if (empty($secretKey) || empty($clientId)) {
            throw Exceptions::create('format.is_null');
        }
        if (empty($mode)) {
            throw Exceptions::create('format.null_mode');
        }

        if (! is_array($url)) {
            throw Exceptions::create('format.null_mode');
        }

        self::$secretKey = $secretKey;
        self::$clientId = $clientId;
        self::$BaseUrl = $url[$mode];
    }

    /**
     * @return mixed
     */
    public static function getClientId()
    {
        return self::$clientId;
    }

    /**
     * @return mixed
     */
    public static function getBaseUrl()
    {
        return self::$BaseUrl;
    }

    /**
     * @return mixed
     */
    public static function getSecretKey()
    {
        return self::$secretKey;
    }
}
