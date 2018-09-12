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

/**
 * Class ReCaptchaBuilderV2
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaBuilderV2 extends ReCaptchaBuilder {

    /**
     * Write ReCAPTCHA HTML tag in your FORM
     * Insert before </form> tag
     * @return string
     */
    public function htmlFormSnippet() {

        return ($this->version == 'v2') ? '<div class="g-recaptcha" data-sitekey="' . $this->api_site_key . '"></div>' : '';
    }

}