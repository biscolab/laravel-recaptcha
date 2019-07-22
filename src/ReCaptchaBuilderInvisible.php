<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaBuilderInvisible.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha;

/**
 * Class ReCaptchaBuilderInvisible
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaBuilderInvisible extends ReCaptchaBuilder {

	/**
	 * ReCaptchaBuilderInvisible constructor.
	 *
	 * @param string   $api_site_key
	 * @param string   $api_secret_key
	 * @param int|null $curl_timeout
	 */
	public function __construct(string $api_site_key, string $api_secret_key, ?int $curl_timeout = null) {

		parent::__construct($api_site_key, $api_secret_key, 'invisible', $curl_timeout);
	}

	/**
	 * Write HTML <button> tag in your HTML code
	 * Insert before </form> tag
	 *
	 * @param string $buttonInnerHTML
	 *
	 * @return string
	 */
	public function htmlFormButton($buttonInnerHTML = 'Submit'): string {

		return ($this->version == 'invisible') ? '<button class="g-recaptcha" data-sitekey="' . $this->api_site_key . '" data-callback="biscolabLaravelReCaptcha">' . $buttonInnerHTML . '</button>' : '';
	}

}