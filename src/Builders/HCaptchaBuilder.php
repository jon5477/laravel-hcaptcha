<?php

namespace jon5477\hCaptcha\Builders;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use jon5477\hCaptcha\Exceptions\InvalidConfigurationException;

class HCaptchaBuilder
{
    /**
     * List of allowed HTML "data-*" attributes allowed on the h-captcha div element.
     * Full list at https://docs.hcaptcha.com/configuration#hcaptcha-container-configuration
     * @var string[]
     */
    private static $allowed_data_attributes = [
        'theme',
        'size',
        'tabindex',
        'callback',
        'expired-callback',
        'chalexpired-callback',
        'open-callback',
        'close-callback',
        'error-callback',
    ];

    /**
     * @var int
     */
    public const DEFAULT_CURL_TIMEOUT = 10;

    /**
     * @var string
     */
    public const DEFAULT_ONLOAD_JS_FUNCTION = 'laravelHCaptchaOnloadCallback';

    /**
     * @var string
     */
    public const DEFAULT_HCAPTCHA_RULE_NAME = 'hcaptcha';

    /**
     * @var string
     */
    public const DEFAULT_HCAPTCHA_FIELD_NAME = 'h-captcha-response';

    /**
     * @var string
     */
    private $siteKey;
    /**
     * Secret key for hCaptcha verification.
     * @var string
     */
    private $secretKey;

    /**
     * Filters the given array of data-attributes retaining only the hCaptcha allowed data-attributes.
     *
     * @param array|null $attributes
     * @return array
     */
    private static function filterAttributes(?array $attributes = []): array
    {
        return array_filter($attributes, function ($key) {
            return in_array($key, self::$allowed_data_attributes);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Generates the error message for an InvalidConfigurationException.
     * @param string $property
     * @param string $value
     * @return string
     */
    private static function getInvalidPropertyMessage(string $property, string $value): string
    {
        return 'Property "' . $property . '" ("data-' . $property . '") must be different from "' . $value . '"';
    }

    /**
     * @param string $siteKey
     * @param string $secretKey
     */
    public function __construct(string $siteKey, string $secretKey)
    {
        $this->siteKey = $siteKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @return int
     */
    public function getCurlTimeout(): int
    {
        return Config::get('hcaptcha.curl_timeout', self::DEFAULT_CURL_TIMEOUT);
    }

    /**
     * Returns the script HTML tag as a string for rendering.
     * You should insert this in your <head></head> tag
     *
     * @param array|null $configuration
     *
     * @return string
     * @throws InvalidConfigurationException
     */
    public function htmlScriptTagJsApi(?array $configuration = []): string
    {
        $query = [];
        $html = '';

        // Language: "hl" parameter
        // resources $configuration parameter overrides default language
        $language = Arr::get($configuration, 'lang');
        if (!$language) {
            $language = Config::get('hcaptcha.default_language', null);
        }
        if ($language) {
            Arr::set($query, 'hl', $language);
        }

        // Onload JS callback function: "onload" parameter
        // "render" parameter set to "explicit"
        if (Config::get('hcaptcha.explicit', null)) {
            Arr::set($query, 'render', 'explicit');
            Arr::set($query, 'onload', self::DEFAULT_ONLOAD_JS_FUNCTION);
            $html = $this->getOnLoadCallback();
        }

        // Create query string
        $query = $query ? '?' . http_build_query($query) : '';
        $html .= '<script src="https://js.hcaptcha.com/1/api.js' . $query . '" async defer></script>';
        return $html;
    }

    /**
     * @return string
     * @throws InvalidConfigurationException
     */
    private function getOnLoadCallback(): string
    {
        $attributes = $this->getTagAttributes();
        // https://docs.hcaptcha.com/configuration#hcaptcharendercontainer-params
        return "<script>var " . self::DEFAULT_ONLOAD_JS_FUNCTION . " = function() {hcaptcha.render('hcaptcha-element', " . json_encode($attributes) . ")};</script>";
    }

    /**
     * @param array|null $attributes
     * @return string
     * @throws InvalidConfigurationException
     */
    public function htmlFormSnippet(?array $attributes = []): string
    {
        $data_attributes = [];
        $config_data_attributes = array_merge($this->getTagAttributes(), self::filterAttributes($attributes));
        ksort($config_data_attributes);
        foreach ($config_data_attributes as $k => $v) {
            if ($v) {
                $data_attributes[] = 'data-' . $k . '="' . $v . '"';
            }
        }
        return '<div class="h-captcha" ' . implode(" ", $data_attributes) . ' id="hcaptcha-element"></div>';
    }

    /**
     * @return array
     * @throws InvalidConfigurationException
     */
    private function getTagAttributes(): array
    {
        $attributes = [
            'sitekey' => $this->siteKey
        ];
        $attributes = array_merge($attributes, Config::get('hcaptcha.tag_attributes', []));
        $keys = ['callback', 'expired-callback', 'chalexpired-callback', 'open-callback', 'close-callback', 'error-callback'];
        foreach ($keys as $key) {
            if (Arr::get($attributes, $key) === HCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION) {
                throw new InvalidConfigurationException(self::getInvalidPropertyMessage($key, HCaptchaBuilder::DEFAULT_ONLOAD_JS_FUNCTION));
            }
        }
        return $attributes;
    }

    /**
     * Validate the client response with hCaptcha.
     *
     * @param $response
     * @return bool
     */
    public function validate(string $response): bool
    {
        $params = http_build_query([
            'secret' => $this->secretKey,
            'response' => $response,
        ]);
        $curl = curl_init('https://hcaptcha.com/siteverify');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->getCurlTimeout());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_resp = curl_exec($curl);
        if (!$curl_resp) {
            return false;
        }
        $resp_arr = json_decode(trim($curl_resp), true);
        return $resp_arr['success'];
    }
}
