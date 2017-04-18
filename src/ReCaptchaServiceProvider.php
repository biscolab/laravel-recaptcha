<?php

namespace Biscolab\ReCaptcha;

use Illuminate\Support\ServiceProvider;
use Biscolab\ReCaptcha\ReCaptchaBuilder;
use Validator;

class ReCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    public function boot()
    {
        $this->addValidationRule();
        $this->publishes([
            __DIR__ . '/../config/recaptcha.php' => config_path('recaptcha.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/recaptcha.php', 'recaptcha'
        );

        $this->registerReCaptchaBuilder();

        $this->app->alias('recaptcha', 'Biscolab\ReCaptcha\ReCaptchaBuilder');
    }

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerReCaptchaBuilder()
    {
        $this->app->singleton('recaptcha', function ($app) {
            return new ReCaptchaBuilder(config('recaptcha.api_site_key'), config('recaptcha.api_secret_key'));
        });
    }

    /**
     * Extends Validator to include a recaptcha type
     */
    public function addValidationRule()
    {
        Validator::extendImplicit('recaptcha', function($attribute, $value, $parameters, $validator) {
            return app('recaptcha')->validate($value);
        }, trans('validation.recaptcha'));
    }   

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['recaptcha', 'Biscolab\ReCaptcha\ReCaptchaBuilder'];
    }
 
}
