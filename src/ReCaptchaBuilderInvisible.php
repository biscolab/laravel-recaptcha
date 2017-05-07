<?php

/**
 *
 * Biscolab Laravel ReCaptcha - ReCaptchaBuilderInvisible Class
 * MIT License @ https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 * author: Roberto Belotti - info@robertobelotti.com
 * web : robertobelotti.com, github.com/biscolab
 *
 */

namespace Biscolab\ReCaptcha;

class ReCaptchaBuilderInvisible extends ReCaptchaBuilder {

	/**
	 * Write HTML <button> tag in your HTML code
	 * Insert before </form> tag
	 */
	public function htmlFormButton($buttonInnerHTML = 'Submit')
	{
		return ($this->version == 'invisible')? '<button class="g-recaptcha" data-sitekey="'.$this->api_site_key.'" data-callback="biscolabLaravelReCaptcha">'.$buttonInnerHTML.'</button>' : '';
	}

}