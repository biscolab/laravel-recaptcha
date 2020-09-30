<?php

/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaHelpersV2ExplicitTest.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 2/9/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha\Tests;

use Biscolab\ReCaptcha\ReCaptchaBuilderV2;

class ReCaptchaHelpersV2ExplicitTest extends TestCase
{

    /**
     * @test
     */
    public function testGetOnLoadCallbackFunction()
    {

        $recaptcha = \recaptcha();
        /** @scrutinizer ignore-call */
        $callback = $recaptcha->getOnLoadCallback();

        $this->assertEquals(
            '<script>var biscolabOnloadCallback = function() {grecaptcha.render(\'recaptcha-element\', {"sitekey":"api_site_key","theme":"dark","size":"compact","tabindex":"2","callback":"callbackFunction","expired-callback":"expiredCallbackFunction","error-callback":"errorCallbackFunction"});};</script>',
            $callback
        );
    }

    /**
     * @test
     */
    public function testHtmlScriptTagJsApiHasJavascriptRenderFunction()
    {

        $html = htmlScriptTagJsApi();

        $this->assertEquals(
            '<script>var biscolabOnloadCallback = function() {grecaptcha.render(\'recaptcha-element\', {"sitekey":"api_site_key","theme":"dark","size":"compact","tabindex":"2","callback":"callbackFunction","expired-callback":"expiredCallbackFunction","error-callback":"errorCallbackFunction"});};</script><script src="https://www.google.com/recaptcha/api.js?render=explicit&onload=biscolabOnloadCallback" async defer></script>',
            $html
        );
    }

    /**
     * @test
     */
    public function testTagAttributes()
    {

        $recaptcha = \recaptcha();
        /** @scrutinizer ignore-call */
        $tag_attributes = $recaptcha->getTagAttributes();

        $this->assertArrayHasKey('sitekey', $tag_attributes);
        $this->assertArrayHasKey('theme', $tag_attributes);
        $this->assertArrayHasKey('size', $tag_attributes);
        $this->assertArrayHasKey('tabindex', $tag_attributes);
        $this->assertArrayHasKey('callback', $tag_attributes);
        $this->assertArrayHasKey('expired-callback', $tag_attributes);
        $this->assertArrayHasKey('error-callback', $tag_attributes);

        $this->assertEquals($tag_attributes['sitekey'], 'api_site_key');
        $this->assertEquals($tag_attributes['theme'], 'dark');
        $this->assertEquals($tag_attributes['size'], 'compact');
        $this->assertEquals($tag_attributes['tabindex'], '2');
        $this->assertEquals($tag_attributes['callback'], 'callbackFunction');
        $this->assertEquals($tag_attributes['expired-callback'], 'expiredCallbackFunction');
        $this->assertEquals($tag_attributes['error-callback'], 'errorCallbackFunction');
    }

    /**
     * @test
     */
    public function testExpectReCaptchaInstanceOfReCaptchaBuilderV2()
    {

        $this->assertInstanceOf(ReCaptchaBuilderV2::class, \recaptcha());
    }

    /**
     * @test
     */
    public function testHtmlFormSnippet()
    {

        /** @scrutinizer ignore-call */
        $html_snippet = \recaptcha()->htmlFormSnippet();
        $this->assertEquals(
            '<div class="g-recaptcha" data-callback="callbackFunction" data-error-callback="errorCallbackFunction" data-expired-callback="expiredCallbackFunction" data-sitekey="api_site_key" data-size="compact" data-tabindex="2" data-theme="dark" id="recaptcha-element"></div>',
            $html_snippet
        );
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
        $app['config']->set('recaptcha.version', 'v2');
        $app['config']->set('recaptcha.explicit', true);
        $app['config']->set('recaptcha.tag_attributes', [
            'theme'            => 'dark',
            'size'             => 'compact',
            'tabindex'         => '2',
            'callback'         => 'callbackFunction',
            'expired-callback' => 'expiredCallbackFunction',
            'error-callback'   => 'errorCallbackFunction',
        ]);
    }
}
