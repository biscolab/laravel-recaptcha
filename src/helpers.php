<?php

if (!function_exists('recaptcha')) {
    /**
     * @return Biscolab\ReCaptcha\ReCaptchaBuilder
     */
    function recaptcha()
    {
        return app('recaptcha');
    }
}