<?php

/**
 *
 * Biscolab Laravel ReCaptcha - ReCaptchaBuilder Class
 * MIT License @ https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 * author: Roberto Belotti - info@robertobelotti.com
 * web : robertobelotti.com, github.com/biscolab
 *
 */

namespace Biscolab\ReCaptcha;

use Exception;

class ReCaptchaBuilder {

	/**
	 * The Site key
	 * please visit https://developers.google.com/recaptcha/docs/start
	 */
	protected $api_site_key;

	/**
	 * The Secret key
	 * please visit https://developers.google.com/recaptcha/docs/start	 
	 */	
	protected $api_secret_key;

	/**
	 * The chosen ReCAPTCHA version
	 * please visit https://developers.google.com/recaptcha/docs/start	 
	 */	
	protected $version;

	/**
	 * The API request URI
	 */
	protected $api_url = 'https://www.google.com/recaptcha/api/siteverify';

	public function __construct($api_site_key, $api_secret_key, $version = 'v2')
	{
		$this->api_site_key		= $api_site_key;
		$this->api_secret_key	= $api_secret_key;
		$this->version 			= $version;
	}
	
	/**
	 * Write script HTML tag in you HTML code
	 * Insert before </head> tag
	 *
	 * @param $formId required if you are using invisible ReCaptcha
	 */
	public function htmlScriptTagJsApi($formId = '')
	{
		$html = "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
		if($this->version != 'v2'){
			if(!$formId) throw new Exception("formId required", 1);
			$html.= '<script>
		       function biscolabLaravelReCaptcha(token) {
		         document.getElementById("'.$formId.'").submit();
		       }
		     </script>';
		}
		return $html;
	}

    /**
     * Call out to reCAPTCHA and process the response
     *
     * @param string $response
     *
     * @return bool
     */
    public function validate($response)
    {
        $params = http_build_query([
            'secret'   => $this->api_secret_key,
            'remoteip' => request()->getClientIp(),
            'response' => $response,
        ]);

        $url = $this->api_url. '?' . $params;

        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $curl_response = curl_exec($curl);
        } else {
            $curl_response = file_get_contents($url);
        }
        if (is_null($curl_response) || empty( $curl_response )) {
            return false;
        }
        $response = json_decode(trim($curl_response), true);

        return $response['success'];
    }

}