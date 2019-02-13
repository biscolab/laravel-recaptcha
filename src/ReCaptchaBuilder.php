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
	public function setApiSiteKey(string $api_site_key): ReCaptchaBuilder {

		$this->api_site_key = $api_site_key;

		return $this;
	}

	/**
	 * @param string $api_secret_key
	 *
	 * @return ReCaptchaBuilder
	 */
	public function setApiSecretKey(string $api_secret_key): ReCaptchaBuilder {

		$this->api_secret_key = $api_secret_key;

		return $this;
	}

	/**
	 * @param string $version
	 *
	 * @return ReCaptchaBuilder
	 */
	public function setVersion(string $version): ReCaptchaBuilder {

		$this->version = $version;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getVersion(): string {

		return $this->version;
	}

	/**
	 * @param bool $skip_by_ip
	 *
	 * @return ReCaptchaBuilder
	 */
	public function setSkipByIp(bool $skip_by_ip): ReCaptchaBuilder {

		$this->skip_by_ip = $skip_by_ip;

		return $this;
	}

	/**
	 * @return array|mixed
	 */
	public function getIpWhitelist() {
		$whitelist = config('recaptcha.skip_ip', []);

		if(!is_array($whitelist)) {
			$whitelist = explode(',', $whitelist);
		}

		return $whitelist;
	}

	/**
	 * Checks whether the user IP address is among IPs "to be skipped"
	 *
	 * @return boolean
	 */
	public function skipByIp(): bool {

		return (in_array(request()->ip(), $this->getIpWhitelist()));
	}

	/**
	 * Write script HTML tag in you HTML code
	 * Insert before </head> tag
	 *
	 * @param string|null $formId
	 * @param array|null  $configuration
	 *
	 * @return string
	 * @throws Exception
	 */
	public function htmlScriptTagJsApi(?string $formId = '', ?array $configuration = []): string {

		if ($this->skip_by_ip) {
			return '';
		}

		switch ($this->version) {
			case 'v3':
				$html = "<script src=\"https://www.google.com/recaptcha/api.js?render={$this->api_site_key}\"></script>";
				break;
			default:
				$html = "<script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>";
		}

		if ($this->version == 'invisible') {
			if (!$formId) {
				throw new Exception("formId required", 1);
			}
			$html .= '<script>
		       function biscolabLaravelReCaptcha(token) {
		         document.getElementById("' . $formId . '").submit();
		       }
		     </script>';
		}
		elseif ($this->version == 'v3') {

			$action = array_get($configuration, 'action', 'homepage');

			$js_custom_validation = array_get($configuration, 'custom_validation', '');

			// Check if set custom_validation. That function will override default fetch validation function
			if ($js_custom_validation) {

				$validate_function = ($js_custom_validation) ? "{$js_custom_validation}(token);" : '';
			}
			else {

				$js_then_callback = array_get($configuration, 'callback_then', '');
				$js_callback_catch = array_get($configuration, 'callback_catch', '');

				$js_then_callback = ($js_then_callback) ? "{$js_then_callback}(response)" : '';
				$js_callback_catch = ($js_callback_catch) ? "{$js_callback_catch}(err)" : '';

				$validate_function = "
                fetch('/" . config('recaptcha.default_validation_route', 'biscolab-recaptcha/validate') . "?" . config('recaptcha.default_token_parameter_name', 'token') . "=' + token, {
                    headers: {
                        \"X-Requested-With\": \"XMLHttpRequest\",
                        \"X-CSRF-TOKEN\": csrfToken.content
                    }
                })
                .then(function(response) {
                   	{$js_then_callback}
                })
                .catch(function(err) {
                    {$js_callback_catch}
                });";
			}

			$html .= "<script>
                    var csrfToken = document.head.querySelector('meta[name=\"csrf-token\"]');
                  grecaptcha.ready(function() {
                      grecaptcha.execute('{$this->api_site_key}', {action: '{$action}'}).then(function(token) {
                        {$validate_function}
                      });
                  });
		     </script>";
		}

		return $html;
	}

	/**
	 * @param array|null $configuration
	 *
	 * @return string
	 */
	public function htmlScriptTagJsApiV3(?array $configuration = []): string {

		return $this->htmlScriptTagJsApi('', $configuration);
	}

	/**
	 * Call out to reCAPTCHA and process the response
	 *
	 * @param string $response
	 *
	 * @return boolean|array
	 */
	public function validate($response) {

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
			curl_setopt($curl, CURLOPT_TIMEOUT, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
		}
		else {
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
	 * @return bool
	 */
	protected function returnArray(): bool {

		return ($this->version == 'v3');
	}
}