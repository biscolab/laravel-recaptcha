# laravel-recaptcha
Simple Google ReCaptcha package for Laravel 5

## Installation

You can install the package via composer:

```sh
composer require biscolab/laravel-recaptcha
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
Open `config/recaptcha.php` configuration file and set `api_site_key` and `api_secret_key`:

```php
return [
    'api_site_key'      => 'YOUR_API_SITE_KEY',
    'api_secret_key'    => 'YOUR_API_SECRET_KEY',
];
```

For more invermation about Site Key and Secret Key please visit [Google RaCaptcha developer documentation](https://developers.google.com/recaptcha/docs/start)

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

Insert `{!!ReCaptcha::htmlScriptTagJsApi()!!}` before closing `</head>` tag

```blade
<!DOCTYPE html>
<html>
    <head>
        ...
        {!!ReCaptcha::htmlScriptTagJsApi()!!}
    </head>
```

After you have to insert `{!!ReCaptcha::htmlFormSnippet()!!}` inside the form where you want to use the field `g-recaptcha-response`

```blade
<form>
    ...
    {!!ReCaptcha::htmlFormSnippet()!!}
</form>
```

## Verify submitted data

Add **recaptcha** to your rules

```php
$v = Validator::make(request()->all(), [
    'g-recaptcha-response' => 'recaptcha',
]);
```

Print form errors

```php
dd($v->errors());
```

