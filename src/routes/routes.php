<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - routes.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 21/1/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

\Illuminate\Support\Facades\Route::get(
	config('recaptcha.default_validation_route', 'biscolab-recaptcha/validate'),
	['uses' => 'Biscolab\ReCaptcha\Controllers\ReCaptchaController@validateV3']
)->middleware('web');