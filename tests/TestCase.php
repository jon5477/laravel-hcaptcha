<?php

namespace Tests;

use Illuminate\Foundation\Application;
use jon5477\hCaptcha\Facades\HCaptcha;
use jon5477\hCaptcha\Providers\HCaptchaServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array<int, string>
     */
    protected function getPackageProviders($app)
    {
        return [HCaptchaServiceProvider::class];
    }

    /**
     * Override application aliases.
     *
     * @param Application $app
     *
     * @return array<string, string>
     */
    protected function getPackageAliases($app)
    {
        return ['HCaptcha' => HCaptcha::class];
    }
}
