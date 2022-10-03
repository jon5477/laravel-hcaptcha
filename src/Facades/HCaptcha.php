<?php

namespace jon5477\hCaptcha\Facades;

use Illuminate\Support\Facades\Facade;
use jon5477\hCaptcha\Builders\HCaptchaBuilder;

/**
 * @method static string htmlScriptTagJsApi(?array $config = [])
 * @method static string htmlFormSnippet(?array $attributes = [])
 *
 * @see \jon5477\hCaptcha\Builders\HCaptchaBuilder
 */
class HCaptcha extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return HCaptchaBuilder::class;
    }
}
