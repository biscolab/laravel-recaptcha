<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptcha.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ReCaptcha
 * @package Biscolab\ReCaptcha\Facades
 */
class ReCaptcha extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {

		return 'recaptcha';
	}
}
