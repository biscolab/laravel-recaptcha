<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaBuilderV2.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha;

use Biscolab\ReCaptcha\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Arr;

/**
 * Class ReCaptchaBuilderV2
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaBuilderV2 extends ReCaptchaBuilder
{

    /**
     * ReCaptchaBuilderV2 constructor.
     *
     * @param string $api_site_key
     * @param string $api_secret_key
     */
    public function __construct(string $api_site_key, string $api_secret_key)
    {

        parent::__construct($api_site_key, $api_secret_key, 'v2');
    }

    /**
     * Write ReCAPTCHA HTML tag in your FORM
     * Insert before </form> tag
     * @return string
     */
    public function htmlFormSnippet(): string
    {

        $data_attributes = [];
        $config_data_attributes = $this->getTagAttributes();

        foreach ($config_data_attributes as $k => $v) {
            if ($v) {
                $data_attributes[] = 'data-' . $k . '="' . $v . '"';
            }
        }

        $html = '<div class="g-recaptcha" ' . implode(" ", $data_attributes) . ' id="recaptcha-element"></div>';

        return $html;
    }

    /**
     * @return array
     * @throws InvalidConfigurationException
     */
    public function getTagAttributes(): array
    {

        $tag_attributes = [
            'sitekey' => $this->api_site_key
        ];

        $tag_attributes = array_merge($tag_attributes, config('recaptcha.tag_attributes', []));

        if (Arr::get($tag_attributes, 'callback') === ReCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION) {
            throw new InvalidConfigurationException('Property "callback" ("data-callback") must be different from "' . ReCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION . '"');
        }

        if (Arr::get($tag_attributes, 'expired-callback') === ReCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION) {
            throw new InvalidConfigurationException('Property "expired-callback" ("data-expired-callback") must be different from "' . ReCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION . '"');
        }

        if (Arr::get($tag_attributes, 'error-callback') === ReCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION) {
            throw new InvalidConfigurationException('Property "error-callback" ("data-error-callback") must be different from "' . ReCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION . '"');
        }

        return $tag_attributes;
    }

    /**
     * @return string
     */
    public function getOnLoadCallback(): string
    {

        $attributes = $this->getTagAttributes();

        return "<script>var biscolabOnloadCallback = function() {grecaptcha.render('recaptcha-element', " . json_encode($attributes) . ");};</script>";
    }

}