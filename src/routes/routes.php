<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - routes.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 21/1/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

Route::get(config('recaptcha.default_validation_route', 'biscolab-recaptcha/validate'), function () {

	$token = request()->input(config('recaptcha.default_token_parameter_name', 'token'), '');
	$validation_response = recaptcha()->validate($token);

	return response()->json($validation_response);
})->middleware('web');