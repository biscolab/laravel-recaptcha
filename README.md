**Laravel ReCAPTCHA** is a very simply-to-use Laravel 5 package to embed Google reCAPTCHA in your application.

[![Build Status](https://travis-ci.org/biscolab/laravel-recaptcha.svg?branch=master#img-thumbnail)](https://travis-ci.org/biscolab/laravel-recaptcha)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/biscolab/laravel-recaptcha/badges/quality-score.png?b=master#img-thumbnail)](https://scrutinizer-ci.com/g/biscolab/laravel-recaptcha/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/biscolab/laravel-recaptcha/badges/coverage.png?b=master#img-thumbnail)](https://scrutinizer-ci.com/g/biscolab/laravel-recaptcha/?branch=master)
[![Packagist version](https://img.shields.io/packagist/v/biscolab/laravel-recaptcha.svg#img-thumbnail)](https://packagist.org/packages/biscolab/laravel-recaptcha)
[![Downloads](https://img.shields.io/packagist/dt/biscolab/laravel-recaptcha.svg#img-thumbnail)](https://packagist.org/packages/biscolab/laravel-recaptcha/stats)
[![MIT License](https://img.shields.io/github/license/biscolab/laravel-recaptcha.svg#img-thumbnail)](https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE)

## What is reCAPTCHA?

Google developers says: "reCAPTCHA protects you against spam and other types of automated abuse. Here, we explain how to add reCAPTCHA to your site or application."

You can find further info at <a href="https://developers.google.com/recaptcha/intro" target="_blank" title="Google reCAPTCHA Developer's Guide">Google reCAPTCHA Developer's Guide</a>

## reCAPTCHA available versions

At this moment there are 3 versions available (for web applications):

- **v3**, the latest (<a href="https://developers.google.com/recaptcha/docs/v3" target="_blank">reCAPTCHA v3</a>)
- **v2 checkbox** or simply reCAPTCHA v2 (<a href="https://developers.google.com/recaptcha/docs/display" target="_blank">reCAPTCHA v2</a>)
- **v2 invisible** (<a href="https://developers.google.com/recaptcha/docs/invisible" target="_blank">Invisible reCAPTCHA</a>)

## Get your key first!

First of all you have to create your own API keys <a href="https://www.google.com/recaptcha/admin" target="_blank">here</a>

Follow the instructions and at the end of the process you will find **Site key** and **Secret key**. Keep them close..you will need soon!

## System requirements

| Package version | reCaptcha version             | PHP version           | Laravel version         | 
| --------------- | ----------------------------- | --------------------- | ----------------------- | 
| 6.1             | v3, v2 Invisible, v2 Checkbox | 7.3 or greater        | 7, 8, 9, 10, 11         | 
| 6.0             | v3, v2 Invisible, v2 Checkbox | 7.3 or greater        | 7, 8, 9, 10             | 
| 5.x             | v3, v2 Invisible, v2 Checkbox | 7.3 or greater        | 7, 8, 9                 | 
| 4.2.x to 4.4.x  | v3, v2 Invisible, v2 Checkbox | 7.1 or greater        | 5.5 or greater, 6, 7, 8 | 
| 4.1.x           | v3, v2 Invisible, v2 Checkbox | 7.1 or greater        | 5.5 or greater, 6, 7    | 
| 4.0.x           | v3, v2 Invisible, v2 Checkbox | 7.1 or greater        | 5.5 or greater, 6       | 
| 3.x             | v3, v2 Invisible, v2 Checkbox | 7.1 or greater        | 5.5 or greater, 6 (\*)  | 
| 2.x             | v2 Invisible, v2 Checkbox     | 5.5.9, 7.0 or greater | 5.0 or greater          | 

> (\*) Version 3.6.1 is Laravel 6 ready

## Composer

You can install the package via composer:

```sh
$ composer require biscolab/laravel-recaptcha
```

Laravel 5.5 (or greater) uses package auto-discovery, so doesn't require you to manually add the Service Provider, but if you don't use auto-discovery `ReCaptchaServiceProvider` must be registered in `config/app.php`:

```php
'providers' => [
    ...
    Biscolab\ReCaptcha\ReCaptchaServiceProvider::class,
];
```

You can use the facade for shorter code. Add `ReCaptcha` to your aliases:

```php
'aliases' => [
    ...
    'ReCaptcha' => Biscolab\ReCaptcha\Facades\ReCaptcha::class,
];
```


## Publish package

Create `config/recaptcha.php` configuration file using the following artisan command:

```sh
$ php artisan vendor:publish --provider="Biscolab\ReCaptcha\ReCaptchaServiceProvider"
```

## Set the environment

### Add your API Keys

Open `.env` file and set `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY`:

```php
# in your .env file
RECAPTCHA_SITE_KEY=<YOUR_API_SITE_KEY>
RECAPTCHA_SECRET_KEY=<YOUR_API_SECRET_KEY>
RECAPTCHA_SKIP_IP=<YOUR_IP_LIST>
```

`RECAPTCHA_SKIP_IP` (since v5.2.0, not required, CSV format ) allows you to add a list of IP/CIDR (netmask included).
It will be the value of `skip_ip`

> **The following environment variables have been removed!!!**
> Now only sensitive informations as API keys are allowed as environment variables, that means you have to set configuration values in `config/recaptcha.php`

- ~~RECAPTCHA_DEFAULT_VERSION~~
- ~~RECAPTCHA_CURL_TIMEOUT~~
- ~~RECAPTCHA_DEFAULT_VALIDATION_ROUTE~~
- ~~RECAPTCHA_DEFAULT_TOKEN_PARAMETER_NAME~~
- ~~RECAPTCHA_DEFAULT_LANGUAGE~~

### Complete configuration

Open `config/recaptcha.php` configuration file and set `version`:

```php
return [
    'api_site_key'                  => env('RECAPTCHA_SITE_KEY', ''),
    'api_secret_key'                => env('RECAPTCHA_SECRET_KEY', ''),
    // changed in v4.0.0
    'version'                       => 'v2', // supported: "v3"|"v2"|"invisible"
    // @since v3.4.3 changed in v4.0.0
    'curl_timeout'                  => 10,
    'skip_ip'                       => env('RECAPTCHA_SKIP_IP', []), // array of IP addresses - String: dotted quad format e.g.: "127.0.0.1", IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
    // @since v3.2.0 changed in v4.0.0
    'default_validation_route'      => 'biscolab-recaptcha/validate',
    // @since v3.2.0 changed in v4.0.0
    'default_token_parameter_name' => 'token',
    // @since v3.6.0 changed in v4.0.0
    'default_language'             => null,
    // @since v4.0.0
    'default_form_id'              => 'biscolab-recaptcha-invisible-form', // Only for "invisible" reCAPTCHA
    // @since v4.0.0
    'explicit'                     => false, // true|false
    // @since v4.3.0
    'api_domain'                   => "www.google.com", // default value is "www.google.com"
    // @since v5.1.0
    'empty_message'                => false,
    // @since v5.1.0
    'error_message_key'            => 'validation.recaptcha',
    // @since v4.0.0
    'tag_attributes'               => [
        'theme'                    => 'light', // "light"|"dark"
        'size'                     => 'normal', // "normal"|"compact"
        'tabindex'                 => 0,
        'callback'                 => null, // DO NOT SET "biscolabOnloadCallback"
        'expired-callback'         => null, // DO NOT SET "biscolabOnloadCallback"
        'error-callback'           => null, // DO NOT SET "biscolabOnloadCallback"
    ]
];
```

| Key                                 | Type                    | Description                                                                                                                                                                                                                                                      | Default                               |
| ----------------------------------- | ----------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------- |
| `api_site_key` and `api_secret_key` | `string`                | reCAPTCHA keys you have to create in order to perform Google API authentication. For more information about Site Key and Secret Key please visit [Google reCAPTCHA developer documentation](https://developers.google.com/recaptcha/docs/start)                  | `''`                                  |
| `version`                           | `string`                | indicates the reCAPTCHA version (supported: v3&#124;v2&#124;invisible). Get more info about reCAPTCHA version at <a href="https://developers.google.com/recaptcha/docs/versions" target="_blank">https://developers.google.com/recaptcha/docs/versions</a>       | `'v2'`                                |
| `curl_timeout`                      | `int`                   | the maximum number of seconds to allow cURL functions to execute                                                                                                                                                                                                 | `10`                                  |
| `skip_ip`                           | `array` &#124; `string` | a whitelist of IP addresses (array or CSV) that, if recognized, disable the reCAPTCHA validation (return always true) and if you embed JS code in blade (view) file **NO validation call will be performed**                                                     | `[]`                                  |
| `default_validation_route`          | `string`                | the route called via javascript built-in validation script (v3 only)                                                                                                                                                                                             | `'biscolab-recaptcha/validate'`       |
| `default_token_parameter_name`      | `string`                | the name of "token" GET parameter sent to `default_validation_route` to be validated (v3 only)                                                                                                                                                                   | `'token'`                             |
| `default_language`                  | `string`                | the default language code. It has no effect with v3. See [https://developers.google.com/recaptcha/docs/language](https://developers.google.com/recaptcha/docs/language) for further information                                                                  | `null`                                |
| `default_form_id`                   | `string`                | the default form ID. Only for "invisible" reCAPTCHA                                                                                                                                                                                                              | `'biscolab-recaptcha-invisible-form'` |
| `explicit`                          | `bool`                  | deferring the render can be achieved by specifying your onload callback function and adding parameters to the JavaScript resource. It has no effect with v3 and invisible (supported values: true&#124;false)                                                    | `false`                               |
| `api_domain`                        | `string`                | customize API domain. Default value is `'www.google.com'`, but, if not accessible you ca set that value to `'www.recaptcha.net'`. More info about [Can I use reCAPTCHA globally?](https://developers.google.com/recaptcha/docs/faq#can-i-use-recaptcha-globally) | `'www.google.com'`                    |
| `empty_message`                     | `bool`                  | set default error message to `null`                                                                                                                                                                                                                              | `false`                               |
| `error_message_key`                 | `string`                | set default error message translation key                                                                                                                                                                                                                        | `'validation.recaptcha'`              |

#### (array) tag_attributes

| Key                               | Type     | Description                                                                                                                                                                                                                                                          | Default    |
| --------------------------------- | -------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------- |
| `tag_attributes.theme`            | `string` | the color theme of the widget. (supported values: "light"&#124;"dark")                                                                                                                                                                                               | `'light'`  |
| `tag_attributes.size`             | `string` | the size of the widget. (supported values: "normal"&#124;"compact")                                                                                                                                                                                                  | `'normal'` |
| `tag_attributes.tabindex`         | `int`    | the tabindex of the widget and challenge                                                                                                                                                                                                                             | `0`        |
| `tag_attributes.callback`         | `string` | the name of your callback function, executed when the user submits a successful response. The g-recaptcha-response token is passed to your callback                                                                                                                  | `null`     |
| `tag_attributes.expired-callback` | `string` | the name of your callback function, executed when the reCAPTCHA response expires and the user needs to re-verify                                                                                                                                                     | `null`     |
| `tag_attributes.error-callback`   | `string` | the name of your callback function, executed when reCAPTCHA encounters an error (usually network connectivity) and cannot continue until connectivity is restored. If you specify a function here, you are responsible for informing the user that they should retry | `null`     |

> DO NOT SET `tag_attributes.callback`, `tag_attributes.expired-callback`, `tag_attributes.error-callback` to `biscolabOnloadCallback`. `biscolabOnloadCallback` is the default JavaScript callback function called when **explicit** is set to `true` and widget `onload` event is fired.

Here you can find further details about `tag_attributes.*` [https://developers.google.com/recaptcha/docs/display#render_param](https://developers.google.com/recaptcha/docs/display#render_param)

### Reload config cache file

> **!!! IMPORTANT !!!** Every time you change some configuration run the following shell command:

```sh
$ php artisan config:cache
```

## Have you updated?

If you are migrating from an older version check your `config/recaptcha.php` configuration file and compare it with <a href="https://github.com/biscolab/laravel-recaptcha/blob/master/config/recaptcha.php" target="_blank">https://github.com/biscolab/laravel-recaptcha/blob/master/config/recaptcha.php</a>.

> Make sure `config/recaptcha.php` is updated

## Customize error message

Just for v2 and invisible users.

Before starting please add the validation message to `resources/lang/[LANG]/validation.php` file

```php
return [
    ...
    'recaptcha' => 'Hey!!! :attribute is wrong!',
];
```

## Embed in Blade

Insert `htmlScriptTagJsApi()` helper before closing `</head>` tag.

You can also use `ReCaptcha::htmlScriptTagJsApi()`.

```blade
<!DOCTYPE html>
<html>
    <head>
        ...
        {!! htmlScriptTagJsApi($configuration) !!}
    </head>
```

#### htmlScriptTagJsApi

`htmlScriptTagJsApi` function accepts `$configuration` argument. `$configuration` has different keys depending on which ReCAPTCHA you are using:

- [Checkbox](#recaptcha-v2-checkbox)
- [Invisible](#recaptcha-v2-invisible)

### ReCAPTCHA v2 Checkbox

#### htmlScriptTagJsApi(\$configuration)

`$configuration` argument can have following keys:

- `lang` set reCAPTCHA language. This will override `default_language` in `config/recaptcha.php`. Here you ca find the complete list of availeble languages [https://developers.google.com/recaptcha/docs/language](https://developers.google.com/recaptcha/docs/language)

#### Form set-up

After you have to insert `htmlFormSnippet()` helper inside the form where you want to use the field `g-recaptcha-response`.

You can also use `ReCaptcha::htmlFormSnippet()` .

```blade
<form>
    @csrf

    ...
    {!! htmlFormSnippet() !!}
    <!-- OR -->
    {!! htmlFormSnippet($attributes) !!}
    <input type="submit">
</form>
```

> DO NOT forget `@csrf` blade directive

#### htmlFormSnippet([, array \$attributes = [] ])

`htmlFormSnippet()` function does not require attributes but you can override default config `data-` attributes:

```php
{!! htmlFormSnippet([
    "theme" => "light",
    "size" => "normal",
    "tabindex" => "3",
    "callback" => "callbackFunction",
    "expired-callback" => "expiredCallbackFunction",
    "error-callback" => "errorCallbackFunction",
]) !!}
```

`htmlFormSnippet` methos allows are only folowing attribute names:

- theme
- size
- tabindex
- callback
- expired-callback
- error-callback

> Any different attribute name will be rejected

#### Customization

In `config/recaptcha.php` you can customize reCAPTCHA widget setting `tag_attributes` array values. Take a look to `tag_attributes` section in [Complete configuration](configuration.md#complete-configuration)

### ReCAPTCHA v2 Invisible

#### htmlScriptTagJsApi(\$configuration)

`$configuration` argument can have following keys:

- `form_id` set reCAPTCHA form ID. This will override `default_form_id` in `config/recaptcha.php`. This value will be returned by `getFormId()` function in order to set the form tag `id` property.

#### Form set-up

After you have to insert `htmlFormButton($button_label, $properties)` helper inside the form where you want to use reCAPTCHA.

This function creates submit button therefore you don't have to insert `<input type="submit">` or similar.

You can also use `ReCaptcha::htmlFormButton($button_label, $properties)` .

`$button_label` is what you want to write on the submit button

```html
<form id="{{ getFormId() }}">
  @csrf ... {!! htmlFormButton($button_label, $properties) !!}
</form>
```

> DO NOT forget `@csrf` blade directive

#### getFormId()

`getFormId` function returns the default form ID value. This is the value of either `default_form_id` in `config/recaptcha.php` or `$configuration['form_id']` previously set as arguments of `htmlScriptTagJsApi` helper.

> `$configuration['form_id']` overrides default settings.

#### htmlFormButton()

`htmlFormButton` function accepts 2 arguments:

- `$button_label`: (string: optional) the button lable. For example: `Subscribe!`;
- `$properties`: (array: optional) the HTML button properties. For example:

```php
// $properties =
[
    'class' => 'btn btn-info',
    'data-foo' => 'bar'
]
```

> If `data-sitekey` and `data-callback` properties are set, they will be overwritten

> If `class` property is set the value `g-recaptcha` will be appended

## Verify submitted data

Add `recaptcha` to your rules

```php
$validator = Validator::make(request()->all(), [
    ...
    'g-recaptcha-response' => 'recaptcha',
    // OR since v4.0.0
    recaptchaFieldName() => recaptchaRuleName()
]);

// check if validator fails
if($validator->fails()) {
    ...
    $errors = $validator->errors();
}
```


## Embed in Blade

Insert `htmlScriptTagJsApi($config)` helper before closing `</head>` tag.

```html
<!DOCTYPE html>
<html>
    <head>
        ...
        {!! htmlScriptTagJsApi([
            'action' => 'homepage',
            'callback_then' => 'callbackThen',
            'callback_catch' => 'callbackCatch'
        ]) !!}

        <!-- OR! -->
        
        {!! htmlScriptTagJsApi([
            'action' => 'homepage',
            'custom_validation' => 'myCustomValidation'
        ]) !!}
    </head>
```
`$config` is required and is an associative array containing configuration parameters required for the JavaScript validation handling. 

The keys are:

| Key               | Required  | Description                                                                                                                                                           | Default value |
|-------------------|-----------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------|
| `action` 	        | no        | is the `action` parameter required by reCAPTCHA v3 API (<a href="https://developers.google.com/recaptcha/docs/v3" target="_blank">further info</a>)  	                | `homepage`    |
| `custom_validation`   | no    	| is the name of your custom callback javascript function who will override the built-in javascript validation system of this package                               | empty string  |
| `callback_then`   | no    	| (overlooked if `custom_validation`is set) is the name of your custom callback javascript function called by the built-in javascript validation system of this package in case of response success   	| empty string  |
| `callback_catch` 	| no 	    | (overlooked if `custom_validation`is set) is the name of your custom callback javascript function called by the built-in javascript validation system in this package in case of response fault 	    | empty string  |


## Built-in javascript validation system

As callback of `grecaptcha.execute` an ajax call to `config('recaptcha.default_validation_route')` will be performed using `fetch` function. In case of successful response a Promise object will be received and passed as parameter to the `callback_then` function you have set. In not set, no actions will be performed.

Same will happen with `callback_catch`. `callback_catch` will be called in event of response errors and errors will pass as parameter et that function. If not set, no actions will be performed.

Please, go to <a href="https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch" target="_blank">Using Fetch</a> for further information on `fetch` javascript function.

> **Warning!!! Check browser compatibility** 
`fetch` function has compatibility issues with some browser like IE. Please create a custom validation function and set `custom_validation` with its name. That function has to accept as argument the `token`received from Google reCAPTCHA API.
>
> <a href="https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch#Browser_compatibility" target="_blank">Fetch browser compatibility</a> 


### Validation Laravel route

Default validation route is `config('recaptcha.default_validation_route', 'biscolab-recaptcha/validate')`.  
Route and relative Controller are built-in in the package. The route if filtered and protected by Laravel `web` Middleware, that's why is important you embed `csrf-token` HTML meta tag and send `X-Requested-Wit` and `X-CSRF-TOKEN` headers.

You can also change the validation end-point changing `default_validation_route` value in `recaptcha.php` config file.

```html
<head>
    ...
    <!-- IMPORTANT!!! remember CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
```

### Validation response object

The output will be a JSON containing following data:

* **Default output without errors**
```json
{
    "action":"homepage",
    "challenge_ts":"2019-01-29T00:42:08Z",
    "hostname":"www.yourdomain.ext",
    "score":0.9,
    "success":true
}
```
* **Output when calling IP is included in "skip_ip" config whitelist**
```json
{
    "skip_by_ip":true,
    "score":0.9,
    "success":true
}
```
> If you embed code in your blade file using `htmlScriptTagJsApiV3` helper no validation call will be performed!
>
> More info at <a href="#complete-configuration">Configuration page</a>
* **Output with an empty response from Google reCAPTCHA API**
```json
{
    "error":"cURL response empty",
    "score":0.1,
    "success":false
}
```

In the next paragraph you can learn how handle Validation promise object

### "callback_then" and "callback_catch"

After built-in validation you should do something. How? Using `callback_then` and `callback_catch` functions.

What you have to do is just create functions and set parameters with their names.

* `callback_then` must receive one argument of type `Promise`.

* `callback_catch` must receive one argument of type `string`

The result should be something like that:

```html
<head>
    ...
    <!-- IMPORTANT!!! remember CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    ...
    <script type="text/javascript">
        function callbackThen(response){
        	// read HTTP status
            console.log(response.status);
            
            // read Promise object
            response.json().then(function(data){
                console.log(data);
            });
        }
        function callbackCatch(error){
            console.error('Error:', error)
        }   
    </script>    
    ...
    {!! htmlScriptTagJsApiV3([
        'action' => 'homepage',
        'callback_then' => 'callbackThen',
        'callback_catch' => 'callbackCatch'
    ]) !!}    
</head>
``` 

### "custom_validation" function

As just said you can handle validation with your own function. To do that you have to write your function and set `custom_validation` parameter with its name.

The result should be something like that:

```html
<head>
    ...
    <!-- IMPORTANT!!! remember CSRF token --> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    ...
    <script type="text/javascript">
        function myCustomValidation(token) {
            // do something with token 
        }
    </script>    
    ...
    {!! htmlScriptTagJsApiV3([
        'action' => 'homepage',
        'custom_validation' => 'myCustomValidation'
    ]) !!}    
</head>
``` 
