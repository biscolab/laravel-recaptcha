<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaBuilderV2.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha;

/**
 * Class ReCaptchaBuilderV2
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaBuilderV2 extends ReCaptchaBuilder {

	/**
	 * ReCaptchaBuilderV2 constructor.
	 *
	 * @param string $api_site_key
	 * @param string $api_secret_key
	 */
	public function __construct(string $api_site_key, string $api_secret_key) {

		parent::__construct($api_site_key, $api_secret_key, 'v2');
	}

	/**
	 * Write ReCAPTCHA HTML tag in your FORM
	 * Insert before </form> tag
	 * @return string
	 */
	public function htmlFormSnippet(): string {

		return ($this->version == 'v2') ? '<div class="g-recaptcha" data-sitekey="' . $this->api_site_key . '"></div>' : '';
	}

}