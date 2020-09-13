<?php

/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaBuilderV3.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 22/1/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha;

use Illuminate\Support\Arr;

/**
 * Class ReCaptchaBuilderV3
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaBuilderV3 extends ReCaptchaBuilder
{

    /**
     * ReCaptchaBuilderV3 constructor.
     *
     * @param string $api_site_key
     * @param string $api_secret_key
     */
    public function __construct(string $api_site_key, string $api_secret_key)
    {

        parent::__construct($api_site_key, $api_secret_key, 'v3');
    }

    /**
     * Write script HTML tag in you HTML code
     * Insert before </head> tag
     *
     * @param array|null $configuration
     *
     * @return string
     */
    public function htmlScriptTagJsApi(?array $configuration = []): string
    {

        if ($this->skip_by_ip) {
            return '';
        }

        $html = "<script src=\"" . $this->api_js_url . "?render={$this->api_site_key}\"></script>";

        $action = Arr::get($configuration, 'action', 'homepage');

        $js_custom_validation = Arr::get($configuration, 'custom_validation', '');

        // Check if set custom_validation. That function will override default fetch validation function
        if ($js_custom_validation) {

            $validate_function = ($js_custom_validation) ? "{$js_custom_validation}(token);" : '';
        } else {

            $js_then_callback = Arr::get($configuration, 'callback_then', '');
            $js_callback_catch = Arr::get($configuration, 'callback_catch', '');

            $js_then_callback = ($js_then_callback) ? "{$js_then_callback}(response)" : '';
            $js_callback_catch = ($js_callback_catch) ? "{$js_callback_catch}(err)" : '';

            $validate_function = "
                fetch('/" . config(
                'recaptcha.default_validation_route',
                'biscolab-recaptcha/validate'
            ) . "?" . config(
                'recaptcha.default_token_parameter_name',
                'token'
            ) . "=' + token, {
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

        return $html;
    }
}
