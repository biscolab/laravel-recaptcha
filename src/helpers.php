<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - helpers.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 12/9/2018
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

use Biscolab\ReCaptcha\Facades\ReCaptcha;

if (!function_exists('recaptcha')) {
    /**
     * @return Biscolab\ReCaptcha\ReCaptchaBuilder
     */
    function recaptcha() {

        return app('recaptcha');
    }
}

/**
 * call ReCaptcha::htmlScriptTagJsApi()
 * Write script HTML tag in you HTML code
 * Insert before </head> tag
 *
 * @param $formId required if you are using invisible ReCaptcha
 */
if (!function_exists('htmlScriptTagJsApi')) {

    /**
     * @param string $formId
     *
     * @return string
     */
    function htmlScriptTagJsApi($formId = '') {

        return ReCaptcha::htmlScriptTagJsApi($formId);
    }
}

/**
 * call ReCaptcha::htmlFormButton()
 * Write HTML <button> tag in your HTML code
 * Insert before </form> tag
 *
 * Warning! Using only with ReCAPTCHA INVISIBLE
 *
 * @param $buttonInnerHTML What you want to write on the submit button
 */
if (!function_exists('htmlFormButton')) {

    /**
     * @return Biscolab\ReCaptcha\ReCaptchaBuilder::htmlFormButton()
     */
    function htmlFormButton($buttonInnerHTML = 'Submit') {

        return ReCaptcha::htmlFormButton($buttonInnerHTML);
    }
}

/**
 * call ReCaptcha::htmlFormSnippet()
 * Write ReCAPTCHA HTML tag in your FORM
 * Insert before </form> tag
 *
 * Warning! Using only with ReCAPTCHA v2
 */
if (!function_exists('htmlFormSnippet')) {

    /**
     * @return Biscolab\ReCaptcha\ReCaptchaBuilder::htmlFormSnippet()
     */
    function htmlFormSnippet() {

        return ReCaptcha::htmlFormSnippet();
    }
}

