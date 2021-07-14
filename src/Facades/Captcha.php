<?php

namespace Nuary\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nuary\Redis-Captcha
 */
class Captcha extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'captcha';
    }
}
