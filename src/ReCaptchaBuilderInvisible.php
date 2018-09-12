<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaBuilderInvisible.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha;

/**
 * Class ReCaptchaBuilderInvisible
 * @package Biscolab\ReCaptcha
 */
class ReCaptchaBuilderInvisible extends ReCaptchaBuilder {

    /**
     * Write HTML <button> tag in your HTML code
     * Insert before </form> tag
     *
     * @param string $buttonInnerHTML
     *
     * @return string
     */
    public function htmlFormButton($buttonInnerHTML = 'Submit') {

        return ($this->version == 'invisible') ? '<button class="g-recaptcha" data-sitekey="' . $this->api_site_key . '" data-callback="biscolabLaravelReCaptcha">' . $buttonInnerHTML . '</button>' : '';
    }

}