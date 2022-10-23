<?php

/**
 * For a full list of available configuration options,
 * visit: https://docs.hcaptcha.com/configuration
 */
return [

    /*
    |--------------------------------------------------------------------------
    | hCaptcha Site Key
    |--------------------------------------------------------------------------
    |
    | The unique site key assigned by hCaptcha.
    */

    'api_site_key' => env('HCAPTCHA_SITE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | hCaptcha Secret Key
    |--------------------------------------------------------------------------
    |
    | The secret key assigned by hCaptcha for CAPTCHA verification.
    */

    'api_secret_key' => env('HCAPTCHA_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | cURL Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout in seconds for the cURL request.
    */

    'curl_timeout' => 10,

    /*
    |--------------------------------------------------------------------------
    | Skipped IP addresses
    |--------------------------------------------------------------------------
    |
    | IP addresses for which validation will be skipped
    | IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
    */
    'skip_ip' => env('HCAPTCHA_SKIP_IP', []),

    /*
    |--------------------------------------------------------------------------
    | hCaptcha Default Language
    |--------------------------------------------------------------------------
    |
    | The language to use for displaying the CAPTCHA.
    | For a full list, see: https://docs.hcaptcha.com/languages
    */

    'default_language' => null,

    /*
    |--------------------------------------------------------------------------
    | hCaptcha Explicit Rendering
    |--------------------------------------------------------------------------
    |
    | Here you can also defer rendering by specifying a custom onload callback
    | function in which you render the widget yourself.
    | https://docs.hcaptcha.com/configuration#explicitly-render-hcaptcha
    */

    'explicit' => false,

    /*
    |--------------------------------------------------------------------------
    | Error Message
    |--------------------------------------------------------------------------
    |
    | Set to true if you want to display your own custom error message
    | if the CAPTCHA is not supplied. Set this value to the language key
    | of the message to display.
    */

    'empty_message' => false,

    /*
    |--------------------------------------------------------------------------
    | Error Message Language Key
    |--------------------------------------------------------------------------
    |
    | Here you can set a custom error message if the CAPTCHA is not supplied.
    | Set this value to the language key of the message to display.
    */

    'error_message_key' => 'validation.hcaptcha',

    /*
    |--------------------------------------------------------------------------
    | hCaptcha Container Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can define custom HTML data attributes on the rendered div
    | element. For a full list of available options, see:
    | https://docs.hcaptcha.com/configuration#hcaptcha-container-configuration
    */
    'tag_attributes' => [

        /**
         * light | dark
         *
         * Set the color theme of the widget. Defaults to light.
         */
        'theme' => 'light',

        /**
         * normal | compact
         *
         * Set the size of the widget. Defaults to normal.
         */
        'size' => 'normal',

        /**
         * <integer>
         *
         * Set the tabindex of the widget and popup. When appropriate,
         * can make navigation more intuitive on your site. Defaults to 0.
         */
        'tabindex' => 0,

        /**
         * <function name>
         *
         * Called when the user submits a successful response.
         * The h-captcha-response token is passed to your callback.
         *
         * DO NOT SET "laravelHCaptchaOnloadCallback"
         */
        'callback' => null,

        /**
         * <function name>
         *
         * Called when the passcode response expires and the user must re-verify.
         *
         * DO NOT SET "laravelHCaptchaOnloadCallback"
         */
        'expired-callback' => null,

        /**
         * <function name>
         *
         * Called when the user display of a challenge times out with no answer.
         *
         * DO NOT SET "laravelHCaptchaOnloadCallback"
         */
        'chalexpired-callback' => null,

        /**
         * <function name>
         *
         * Called when the user display of a challenge starts.
         *
         * DO NOT SET "laravelHCaptchaOnloadCallback"
         */
        'open-callback' => null,

        /**
         * <function name>
         *
         * Called when the user dismisses a challenge.
         *
         * DO NOT SET "laravelHCaptchaOnloadCallback"
         */
        'close-callback' => null,

        /**
         * <function name>
         *
         * Called when hCaptcha encounters an error and cannot continue.
         * If you specify an error callback, you must inform the user
         * that they should retry. Please see
         * https://docs.hcaptcha.com/configuration#error-codes
         * for a full list containing the possible error codes.
         *
         * DO NOT SET "laravelHCaptchaOnloadCallback"
         */
        'error-callback' => null,
    ]
];
