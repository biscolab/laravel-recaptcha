<?php

namespace Biscolab\ReCaptcha;

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
	 * The API request URI
	 */
	protected $api_url = 'https://www.google.com/recaptcha/api/siteverify';

	public function __construct($api_site_key, $api_secret_key)
	{
		$this->api_site_key		= $api_site_key;
		$this->api_secret_key	= $api_secret_key;
	}
	
	/**
	 * Write script HTML tag in you HTML code
	 * Insert before </head> tag
	 */
	public function htmlScriptTagJsApi()
	{
		return "<script src='https://www.google.com/recaptcha/api.js'></script>";
	}

	/**
	 * Write HTML tag in you HTML code
	 * Insert before </head> tag
	 */
	public function htmlFormSnippet()
	{
		return "<div class='g-recaptcha' data-sitekey='".$this->api_site_key."'></div>";
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