<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaBuilder.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha;

use Exception;

class ReCaptchaBuilder {

    /**
     * The Site key
     * please visit https://developers.google.com/recaptcha/docs/start
     * @var string
     */
    protected $api_site_key;

    /**
     * The Secret key
     * please visit https://developers.google.com/recaptcha/docs/start
     * @var string
     */
    protected $api_secret_key;

    /**
     * The chosen ReCAPTCHA version
     * please visit https://developers.google.com/recaptcha/docs/start
     * @var string
     */
    protected $version;

    /**
     * Whether is true the ReCAPTCHA is inactive
     * @var boolean
     */
    protected $skip_by_ip = false;

    /**
     * The API request URI
     */
    protected $api_url = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct($api_site_key, $api_secret_key, $version = 'v2') {

        $this->api_site_key = $api_site_key;
        $this->api_secret_key = $api_secret_key;
        $this->version = $version;
        $this->skip_by_ip = self::skipByIp();
    }

    /**
     * Checks whether the user IP address is among IPs "to be skipped"
     *
     * @return boolean
     */
    public static function skipByIp() {

        $skip_ip = (config('recaptcha.skip_ip')) ? config('recaptcha.skip_ip') : [];

        return (in_array(request()->ip(), $skip_ip));
    }

    /**
     * Write script HTML tag in you HTML code
     * Insert before </head> tag
     *
     * @param string $formId
     *
     * @return string
     * @throws Exception
     */
    public function htmlScriptTagJsApi($formId = '') {

        if ($this->skip_by_ip) {
            return '';
        }
        $html = "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
        if ($this->version != 'v2') {
            if (!$formId) {
                throw new Exception("formId required", 1);
            }
            $html .= '<script>
		       function biscolabLaravelReCaptcha(token) {
		         document.getElementById("' . $formId . '").submit();
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
     * @return boolean
     */
    public function validate($response) {

        if ($this->skip_by_ip) {
            return true;
        }

        $params = http_build_query([
            'secret'   => $this->api_secret_key,
            'remoteip' => request()->getClientIp(),
            'response' => $response,
        ]);

        $url = $this->api_url . '?' . $params;

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
        if (is_null($curl_response) || empty($curl_response)) {
            return false;
        }
        $response = json_decode(trim($curl_response), true);

        return $response['success'];

    }
}