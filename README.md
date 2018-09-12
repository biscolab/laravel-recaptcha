# Laravel ReCAPTCHA - v3
Simple Google ReCaptcha package for Laravel 5

## System requirements
PHP 7.1 or grater

Are you still using PHP 5.6? Please go to [V2](https://github.com/biscolab/laravel-recaptcha/tree/v2.0.4)

## Installation

You can install the package via composer:
```sh
composer require biscolab/laravel-recaptcha:^3.0
```
The service **provider** must be registered in `config/app.php`:
```php
'providers' => [
    ...
    Biscolab\ReCaptcha\ReCaptchaServiceProvider::class,
];
```
You can use the facade for shorter code. Add "ReCaptcha" to your aliases:
```php
'aliases' => [
    ...
    'ReCaptcha' => Biscolab\ReCaptcha\Facades\ReCaptcha::class,
];
```
Create `config/recaptcha.php` configuration file using:
```su
php artisan vendor:publish --provider="Biscolab\ReCaptcha\ReCaptchaServiceProvider"
```

## Configuration

### Add your API Keys
Open `config/recaptcha.php` configuration file and set `api_site_key`, `api_secret_key` and `version`:
```php
return [
    'api_site_key'      => 'YOUR_API_SITE_KEY',
    'api_secret_key'    => 'YOUR_API_SECRET_KEY',
    'version'           => 'v2' // supported: v2|invisible 
    'skip_ip'           => [] // array of IP addresses - String: dotted quad format e.g.: 127.0.0.1
];
```
For more invermation about Site Key and Secret Key please visit [Google RaCaptcha developer documentation](https://developers.google.com/recaptcha/docs/start)
Get more info about ReCAPTCHA version at https://developers.google.com/recaptcha/docs/versions
**skip_ip** is a list of IP addresses that, if recognized, disable the recaptcha validation (return always true).

### Have you updated?
If you are migrating from an older version add `skip_ip` array in `recaptcha.php` configuration file.

### Customize error message
Before starting please add validation recaptcha message to `resources/lang/[LANG]/validation.php` file
```php
return [
    ...
    'recaptcha' => 'Hey!!! :attribute is wrong!',
];
```

## How to use

### Embed in Blade

Insert `htmlScriptTagJsApi($formId)` helper before closing `</head>` tag
You can also use `ReCaptcha::htmlScriptTagJsApi($formId)`.
`$formId` is required only if you are using **ReCAPTCHA INVISIBLE**
```blade
<!DOCTYPE html>
<html>
    <head>
        ...
        {!! htmlScriptTagJsApi(/* $formId - INVISIBLE version only */) !!}
        or
        {!! ReCaptcha::htmlScriptTagJsApi(/* $formId - INVISIBLE version only */) !!}
    </head>
```

#### If you are using ReCAPTCHA v2
After you have to insert `htmlFormSnippet()` helper inside the form where you want to use the field `g-recaptcha-response`
You can also use `ReCaptcha::htmlFormSnippet()` .
```blade
<form>
    ...
    {!! htmlFormSnippet() !!}
    <input type="submit">
</form>
```

#### If you are using ReCAPTCHA INVISIBLE
After you have to insert `htmlFormButton($buttonInnerHTML)` helper inside the form where you want to use ReCAPTCHA. This function creates submit button therefore **you don't have to insert <input type="submit"> or similar**.
You can also use `ReCaptcha::htmlFormButton($buttonInnerHTML)` .
`$buttonInnerHTML` is what you want to write on the submit button
```blade
<form>
    ...
    {!! htmlFormButton(/* $buttonInnerHTML - Optional */) !!}
</form>
```

## Verify submitted data

Add **recaptcha** to your rules
```php
$v = Validator::make(request()->all(), [
    ...
    'g-recaptcha-response' => 'recaptcha',
]);
```

Print form errors
```php
$errors = $v->errors();
```

## Test

```sh
composer test
```