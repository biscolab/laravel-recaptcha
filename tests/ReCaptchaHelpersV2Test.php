<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaHelpersV2Test.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 8/8/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */


namespace Biscolab\ReCaptcha\Tests;

use Biscolab\ReCaptcha\Facades\ReCaptcha;
use Biscolab\ReCaptcha\ReCaptchaServiceProvider;

class ReCaptchaHelpersV2Test extends TestCase
{

	/**
	 * @test
	 */
	public function testHtmlScriptTagJsApiCalledByFacade()
	{
		ReCaptcha::shouldReceive('htmlScriptTagJsApi')
			->once()
			->with("key");

		htmlScriptTagJsApi("key");

	}

	/**
	 * @test
	 */
	public function testHtmlScriptTagJsApiV3CalledByFacade()
	{
		ReCaptcha::shouldReceive('htmlScriptTagJsApiV3')
			->once()
			->with([]);

		htmlScriptTagJsApiV3([]);

	}

	/**
	 * @test
	 * @expectedException \TypeError
	 */
	public function testHtmlFormButtonCalledByFacade()
	{
		ReCaptcha::shouldReceive('htmlFormButton')
			->once()
			->with("key");

		htmlFormButton("key");

	}

	/**
	 * @test
	 */
	public function testHtmlFormSnippetCalledByFacade()
	{
		ReCaptcha::shouldReceive('htmlFormSnippet')
			->once();

		htmlFormSnippet();

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
		$app['config']->set('recaptcha.api_site_key', 'api_site_key');
		$app['config']->set('recaptcha.version', 'v2');
	}
}