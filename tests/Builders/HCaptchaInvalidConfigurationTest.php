<?php

namespace Tests\Builders;

use Illuminate\Foundation\Application;
use jon5477\hCaptcha\Builders\HCaptchaBuilder;
use jon5477\hCaptcha\Exceptions\InvalidConfigurationException;
use Tests\TestCase;

class HCaptchaInvalidConfigurationTest extends TestCase
{
    public function testHtmlScriptTagJsApiThrowsInvalidConfigurationException()
    {
        $this->expectException(InvalidConfigurationException::class);
        htmlScriptTagJsApi();
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('hcaptcha.api_site_key', 'api_site_key');
        $app['config']->set('hcaptcha.api_secret_key', 'api_secret_key');
        $app['config']->set('hcaptcha.explicit', true);
        $app['config']->set('hcaptcha.tag_attributes.callback', HCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION);
    }
}
