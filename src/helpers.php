<?php

use jon5477\hCaptcha\Facades\HCaptcha;

if (!function_exists('htmlScriptTagJsApi')) {
    function htmlScriptTagJsApi(?array $config = []): string
    {
        return HCaptcha::htmlScriptTagJsApi($config);
    }
}

if (!function_exists('htmlFormSnippet')) {
    function htmlFormSnippet(?array $attributes = []): string
    {
        return HCaptcha::htmlFormSnippet($attributes);
    }
}
