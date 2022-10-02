<?php

namespace Tests\Builders;

use jon5477\hCaptcha\Builders\HCaptchaBuilder;
use jon5477\hCaptcha\Exceptions\InvalidConfigurationException;
use Tests\TestCase;

class HCaptchaBuilderTest extends TestCase
{
    public const RANDOM_UUID = 'cd9dab97-9dd2-47f4-80a1-1ce7d20f2369';

    public function test__construct()
    {
        $builder = new HCaptchaBuilder(self::RANDOM_UUID, 'secret_key');
        $this->assertNotNull($builder);
    }

    public function testGetCurlTimeout()
    {
        $builder = new HCaptchaBuilder(self::RANDOM_UUID, 'secret_key');
        $this->assertEquals(10, $builder->getCurlTimeout());
    }

    /**
     * @throws InvalidConfigurationException
     */
    public function testHtmlScriptTagJsApi()
    {
        $builder = new HCaptchaBuilder(self::RANDOM_UUID, 'secret_key');
        $html = $builder->htmlScriptTagJsApi();
        $this->assertEquals('<script src="https://js.hcaptcha.com/1/api.js" async defer></script>', $html);
    }

    /**
     * @throws InvalidConfigurationException
     */
    public function testHtmlFormSnippet()
    {
        $builder = new HCaptchaBuilder(self::RANDOM_UUID, 'secret_key');
        $html = $builder->htmlFormSnippet();
        $this->assertEquals('<div class="h-captcha" data-sitekey="' . self::RANDOM_UUID . '" data-size="normal" data-theme="light" id="hcaptcha-element"></div>', $html);
    }

    public function testValidate()
    {
        // Test publisher account
        $builder = new HCaptchaBuilder('10000000-ffff-ffff-ffff-000000000001', '0x0000000000000000000000000000000000000000');
        $valid = $builder->validate('10000000-aaaa-bbbb-cccc-000000000001');
        $this->assertTrue($valid);
        // Test enterprise account (safe end user)
        $builder = new HCaptchaBuilder('20000000-ffff-ffff-ffff-000000000002', '0x0000000000000000000000000000000000000000');
        $valid = $builder->validate('20000000-aaaa-bbbb-cccc-000000000002');
        $this->assertTrue($valid);
        // Test enterprise account (bot detected)
        $builder = new HCaptchaBuilder('30000000-ffff-ffff-ffff-000000000003', '0x0000000000000000000000000000000000000000');
        $valid = $builder->validate('30000000-aaaa-bbbb-cccc-000000000003');
        $this->assertTrue($valid);
    }
}
