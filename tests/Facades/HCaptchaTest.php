<?php

namespace Tests\Facades;

use jon5477\hCaptcha\Facades\HCaptcha;
use Tests\TestCase;

class HCaptchaTest extends TestCase
{
    public function testHtmlFormSnippet()
    {
        $html = HCaptcha::htmlFormSnippet(['test' => 'invalid']);
        $this->assertEquals('<div class="h-captcha" data-size="normal" data-theme="light" id="hcaptcha-element"></div>', $html);
    }

    public function testTestHtmlScriptTagJsApi()
    {
        $html = HCaptcha::htmlScriptTagJsApi(['lang' => 'en']);
        $this->assertEquals('<script src="https://js.hcaptcha.com/1/api.js?hl=en" async defer></script>', $html);
    }
}
