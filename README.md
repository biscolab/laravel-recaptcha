# laravel-recaptcha
Simple ReCaptcha package for Laravel 5

## Installation

You can install the package via composer:
```
composer require biscolab/laravel-recaptcha
```
The service **provider** must be registered in `config/app.php`:
```
'providers' => [
    ...
    Biscolab\ReCaptcha\ReCaptchaServiceProvider::class,
];
```
You can use the facade for shorter code. Add "ReCaptcha" to your aliases:
```
'aliases' => [
    ...
    'ReCaptcha' => Biscolab\ReCaptcha\Facades\ReCaptcha::class,
];
```
Create `config/recaptcha.php` configuration file using:
```
php artisan vendor:publish --provider="Biscolab\ReCaptcha\ReCaptchaServiceProvider"
```

## Configuration

comung soon
