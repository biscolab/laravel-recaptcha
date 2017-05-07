<?php

/**
 *
 * Biscolab Laravel ReCaptcha configuration file
 * MIT License @ https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 * author: Roberto Belotti - info@robertobelotti.com
 * web : robertobelotti.com, github.com/biscolab
 *
 * To configure correctly please visit https://developers.google.com/recaptcha/docs/start
 *
 */

return [

	/**
	 *
	 * The site key
	 * get site key @ www.google.com/recaptcha/admin
	 *
	 */
    'api_site_key'      => '',

	/**
	 *
	 * The secret key
	 * get secret key @ www.google.com/recaptcha/admin
	 *
	 */    
    'api_secret_key'    => '',

    /**
     *
     * ReCATCHA version
     * Supported: "v2", "invisible",
     *
     * get more info @ https://developers.google.com/recaptcha/docs/versions
     *
     */
    'version'			=> 'v2'  
];