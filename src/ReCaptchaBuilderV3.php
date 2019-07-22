<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaBuilderV3.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 22/1/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha;

/**
 * Class ReCaptchaBuilderV3
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaBuilderV3 extends ReCaptchaBuilder {

	/**
	 * ReCaptchaBuilderV3 constructor.
	 *
	 * @param string   $api_site_key
	 * @param string   $api_secret_key
	 * @param int|null $curl_timeout
	 */
	public function __construct(string $api_site_key, string $api_secret_key, ?int $curl_timeout = null) {

		parent::__construct($api_site_key, $api_secret_key, 'v3', $curl_timeout);
	}

}