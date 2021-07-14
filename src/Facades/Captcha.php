<?php

namespace Lh\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lh\Redis-Captcha
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
