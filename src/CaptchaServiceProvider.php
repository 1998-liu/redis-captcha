<?php

namespace Lh\Captcha;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

/**
 * Class CaptchaServiceProvider
 * @package Lh\Captcha
 */
class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return null
     */
    public function boot()
    {
        // HTTP routing
        if (strpos($this->app->version(), 'Lumen') !== false) {
            /* @var Router $router */
            $router = $this->app['router'];
            $router->get('captcha/api[/{config}]', 'Lh\Captcha\LumenCaptchaController@getCaptchaApi');
            $router->get('captcha[/{config}]', 'Lh\Captcha\LumenCaptchaController@getCaptcha');
        } else {
            // Publish configuration files
            $this->publishes([
                __DIR__ . '/../config/captcha.php' => config_path('captcha.php')
            ], 'config');
            
            /* @var Router $router */
            $router = $this->app['router'];
            if ((double)$this->app->version() >= 5.2) {
                $router->get('captcha/api/{config?}', '\Lh\Captcha\CaptchaController@getCaptchaApi')->middleware('web');
                $router->get('captcha/{config?}', '\Lh\Captcha\CaptchaController@getCaptcha')->middleware('web');
            } else {
                $router->get('captcha/api/{config?}', '\Lh\Captcha\CaptchaController@getCaptchaApi');
                $router->get('captcha/{config?}', '\Lh\Captcha\CaptchaController@getCaptcha');
            }
        }

        /* @var Factory $validator */
        $validator = $this->app['validator'];

        // Validator extensions
        $validator->extend('captcha', function ($attribute, $value, $parameters) {
            return captcha_check($value);
        });

        // Validator extensions
        $validator->extend('captcha_api', function ($attribute, $value, $parameters) {
            return captcha_api_check($value, $parameters[0]);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge configs
        $this->mergeConfigFrom(
            __DIR__ . '/../config/captcha.php',
            'captcha'
        );

        // Bind captcha
        $this->app->bind('captcha', function ($app) {
            return new Captcha(
                $app['Illuminate\Filesystem\Filesystem'],
                $app['Illuminate\Contracts\Config\Repository'],
                $app['Intervention\Image\ImageManager'],
                app('session'),
                $app['Illuminate\Hashing\BcryptHasher'],
                $app['Illuminate\Support\Str']
            );
        });
    }
}
