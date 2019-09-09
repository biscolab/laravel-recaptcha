<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaInvalidConfigurationTest.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 4/9/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha\Tests;

use Biscolab\ReCaptcha\Exceptions\InvalidConfigurationException;
use Biscolab\ReCaptcha\ReCaptchaBuilder;

/**
 * Class ReCaptchaInvalidConfigurationTest
 * @package Biscolab\ReCaptcha\Tests
 */
class ReCaptchaInvalidConfigurationTest extends TestCase
{

    /**
     * @test
     */
    public function testV2HtmlScriptTagJsApiThrowsInvalidConfigurationException()
    {

        $this->expectException(InvalidConfigurationException::class);

        htmlScriptTagJsApi();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {

        $app['config']->set('recaptcha.api_site_key', 'api_site_key');
        $app['config']->set('recaptcha.api_secret_key', 'api_secret_key');
        $app['config']->set('recaptcha.explicit', true);
        $app['config']->set('recaptcha.tag_attributes.callback', ReCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION);
    }

}