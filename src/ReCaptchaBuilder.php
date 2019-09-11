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

use Illuminate\Support\Arr;

/**
 * Class ReCaptchaBuilder
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaBuilder
{

    /**
     * @var string
     */
    const DEFAULT_API_VERSION = 'v2';

    /**
     * @var int
     */
    const DEFAULT_CURL_TIMEOUT = 10;

    /**
     * @var string
     */
    const DEFAULT_ONLOAD_JS_FUNCTION = 'biscolabOnloadCallback';

    /**
     * @var string
     */
    const DEFAULT_RECAPTCHA_RULE_NAME = 'recaptcha';

    /**
     * @var string
     */
    const DEFAULT_RECAPTCHA_FIELD_NAME = 'g-recaptcha-response';

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

    /**
     * ReCaptchaBuilder constructor.
     *
     * @param string      $api_site_key
     * @param string      $api_secret_key
     * @param null|string $version
     */
    public function __construct(
        string $api_site_key,
        string $api_secret_key,
        ?string $version = self::DEFAULT_API_VERSION
    ) {

        $this->setApiSiteKey($api_site_key);
        $this->setApiSecretKey($api_secret_key);
        $this->setVersion($version);
        $this->setSkipByIp($this->skipByIp());
    }

    /**
     * @param string $api_site_key
     *
     * @return ReCaptchaBuilder
     */
    public function setApiSiteKey(string $api_site_key): ReCaptchaBuilder
    {

        $this->api_site_key = $api_site_key;

        return $this;
    }

    /**
     * @param string $api_secret_key
     *
     * @return ReCaptchaBuilder
     */
    public function setApiSecretKey(string $api_secret_key): ReCaptchaBuilder
    {

        $this->api_secret_key = $api_secret_key;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurlTimeout(): int
    {

        return config('recaptcha.curl_timeout', self::DEFAULT_CURL_TIMEOUT);
    }

    /**
     * @param string $version
     *
     * @return ReCaptchaBuilder
     */
    public function setVersion(string $version): ReCaptchaBuilder
    {

        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {

        return $this->version;
    }

    /**
     * @param bool $skip_by_ip
     *
     * @return ReCaptchaBuilder
     */
    public function setSkipByIp(bool $skip_by_ip): ReCaptchaBuilder
    {

        $this->skip_by_ip = $skip_by_ip;

        return $this;
    }

    /**
     * @return array|mixed
     */
    public function getIpWhitelist()
    {

        $whitelist = config('recaptcha.skip_ip', []);

        if (!is_array($whitelist)) {
            $whitelist = explode(',', $whitelist);
        }

        $whitelist = array_map(function ($item) {

            return trim($item);
        }, $whitelist);

        return $whitelist;
    }

    /**
     * Checks whether the user IP address is among IPs "to be skipped"
     *
     * @return boolean
     */
    public function skipByIp(): bool
    {

        return (in_array(request()->ip(), $this->getIpWhitelist()));
    }

    /**
     * Write script HTML tag in you HTML code
     * Insert before </head> tag
     *
     * @param array|null $configuration
     *
     * @return string
     * @throws \Exception
     */
    public function htmlScriptTagJsApi(?array $configuration = []): string
    {

        $query = [];
        $html = '';

        // Language: "hl" parameter
        // resources $configuration parameter overrides default language
        $language = Arr::get($configuration, 'lang');
        if (!$language) {
            $language = config('recaptcha.default_language', null);
        }
        if ($language) {
            Arr::set($query, 'hl', $language);
        }

        // Onload JS callback function: "onload" parameter
        // "render" parameter set to "explicit"
        if (config('recaptcha.explicit', null) && $this->version === 'v2') {
            Arr::set($query, 'render', 'explicit');
            Arr::set($query, 'onload', self::DEFAULT_ONLOAD_JS_FUNCTION);

            /** @scrutinizer ignore-call */
            $html = $this->getOnLoadCallback();
        }

        // Create query string
        $query = ($query) ? '?' . http_build_query($query) : "";
        $html .= "<script src=\"https://www.google.com/recaptcha/api.js" . $query . "\" async defer></script>";

        return $html;
    }

    /**
     * Call out to reCAPTCHA and process the response
     *
     * @param string $response
     *
     * @return boolean|array
     */
    public function validate($response)
    {

        if ($this->skip_by_ip) {
            if ($this->returnArray()) {
                // Add 'skip_by_ip' field to response
                return [
                    'skip_by_ip' => true,
                    'score'      => 0.9,
                    'success'    => true
                ];
            }

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
            curl_setopt($curl, CURLOPT_TIMEOUT, $this->getCurlTimeout());
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $curl_response = curl_exec($curl);
        } else {
            $curl_response = file_get_contents($url);
        }

        if (is_null($curl_response) || empty($curl_response)) {
            if ($this->returnArray()) {
                // Add 'error' field to response
                return [
                    'error'   => 'cURL response empty',
                    'score'   => 0.1,
                    'success' => false
                ];
            }

            return false;
        }
        $response = json_decode(trim($curl_response), true);

        if ($this->returnArray()) {
            return $response;
        }

        return $response['success'];

    }

    /**
     * @return string
     */
    public function getApiSiteKey(): string
    {

        return $this->api_site_key;
    }

    /**
     * @return string
     */
    public function getApiSecretKey(): string
    {

        return $this->api_secret_key;
    }

    /**
     * @return bool
     */
    protected function returnArray(): bool
    {

        return ($this->version == 'v3');
    }
}