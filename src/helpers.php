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
     * @return Biscolab\ReCaptcha\ReCaptchaBuilder|\Biscolab\ReCaptcha\ReCaptchaBuilderV2|\Biscolab\ReCaptcha\ReCaptchaBuilderInvisible|\Biscolab\ReCaptcha\ReCaptchaBuilderV3
     */
    function recaptcha(): \Biscolab\ReCaptcha\ReCaptchaBuilder
    {

        return app('recaptcha');
    }
}

/**
 * call ReCaptcha::htmlScriptTagJsApi()
 * Write script HTML tag in you HTML code
 * Insert before </head> tag
 *
 * @param $config ['form_id'] required if you are using invisible ReCaptcha
 */
if (!function_exists('htmlScriptTagJsApi')) {

    /**
     * @param array|null $config
     *
     * @return string
     */
    function htmlScriptTagJsApi(?array $config = []): string
    {

        return ReCaptcha::htmlScriptTagJsApi($config);
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
     * @param null|string $button_label
     * @param array|null  $properties
     *
     * @return string
     */
    function htmlFormButton(?string $button_label = 'Submit', ?array $properties = []): string
    {

        return ReCaptcha::htmlFormButton($button_label, $properties);
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
     * @return string
     */
    function htmlFormSnippet(): string
    {

        return ReCaptcha::htmlFormSnippet();
    }
}

/**
 * call ReCaptcha::getFormId()
 * return the form ID
 * Warning! Using only with ReCAPTCHA invisible
 */
if (!function_exists('getFormId')) {

    /**
     * @return string
     */
    function getFormId(): string
    {

        return ReCaptcha::getFormId();
    }
}

/**
 * return ReCaptchaBuilder::DEFAULT_RECAPTCHA_RULE_NAME value ("recaptcha")
 * Use V2 (checkbox and invisible)
 */
if (!function_exists('recaptchaRuleName')) {

    /**
     * @return string
     */
    function recaptchaRuleName(): string
    {

        return \Biscolab\ReCaptcha\ReCaptchaBuilder::DEFAULT_RECAPTCHA_RULE_NAME;
    }
}

/**
 * return ReCaptchaBuilder::DEFAULT_RECAPTCHA_FIELD_NAME value "g-recaptcha-response"
 * Use V2 (checkbox and invisible)
 */
if (!function_exists('recaptchaFieldName')) {

    /**
     * @return string
     */
    function recaptchaFieldName(): string
    {

        return \Biscolab\ReCaptcha\ReCaptchaBuilder::DEFAULT_RECAPTCHA_FIELD_NAME;
    }
}

