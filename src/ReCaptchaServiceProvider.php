<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaServiceProvider.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha;

use Illuminate\Support\ServiceProvider;
use Validator;

/**
 * Class ReCaptchaServiceProvider
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     *
     */
    public function boot() {

        $this->addValidationRule();
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');

        $this->publishes([
            __DIR__ . '/../config/recaptcha.php' => config_path('recaptcha.php'),
        ]);

    }

    /**
     * Extends Validator to include a recaptcha type
     */
    public function addValidationRule() {

        Validator::extendImplicit('recaptcha', function ($attribute, $value, $parameters, $validator) {

            return app('recaptcha')->validate($value);
        }, trans('validation.recaptcha'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/recaptcha.php', 'recaptcha'
        );

        $this->registerReCaptchaBuilder();
    }

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerReCaptchaBuilder() {

        $this->app->singleton('recaptcha', function ($app) {

            $recaptcha_class = '';

            switch (config('recaptcha.version')) {
                case 'v3' :
                    $recaptcha_class = ReCaptchaBuilderV3::class;
                    break;
                case 'v2' :
                    $recaptcha_class = ReCaptchaBuilderV2::class;
                    break;
                case 'invisible':
                    $recaptcha_class = ReCaptchaBuilderInvisible::class;
                    break;
            }

            return new $recaptcha_class(config('recaptcha.api_site_key'), config('recaptcha.api_secret_key'));

        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return ['recaptcha'];
    }

}
