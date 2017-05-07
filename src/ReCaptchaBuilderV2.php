<?php

/**
 *
 * Biscolab Laravel ReCaptcha - ReCaptchaBuilderV2 Class
 * MIT License @ https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 * author: Roberto Belotti - info@robertobelotti.com
 * web : robertobelotti.com, github.com/biscolab
 *
 */

namespace Biscolab\ReCaptcha;

class ReCaptchaBuilderV2 extends ReCaptchaBuilder {

	/**
	 * Write ReCAPTCHA HTML tag in your FORM
	 * Insert before </form> tag
	 */
	public function htmlFormSnippet()
	{
		return ($this->version == 'v2')? '<div class="g-recaptcha" data-sitekey="'.$this->api_site_key.'"></div>' : '';
	}

}