<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaController.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 4/2/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha\Controllers;

use Illuminate\Routing\Controller;

/**
 * Class ReCaptchaController
 * @package Biscolab\ReCaptcha\Controllers
 */
class ReCaptchaController extends Controller
{

	/**
	 * @return array
	 */
	public function validateV3(): array
	{

		$token = request()->input(config('recaptcha.default_token_parameter_name', 'token'), '');

		return recaptcha()->validate($token);
	}
}