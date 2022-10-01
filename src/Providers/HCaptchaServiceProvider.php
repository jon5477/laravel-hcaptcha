<?php

namespace jon5477\hCaptcha\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use jon5477\hCaptcha\Builders\HCaptchaBuilder;

class HCaptchaServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addValidationRule();
        $this->publishes([
            __DIR__ . '/../config/hcaptcha.php' => $this->app->configPath('hcaptcha.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/hcaptcha.php', 'hcaptcha');
        $this->registerHCaptchaBuilder();
    }

    /**
     * @return void
     */
    private function addValidationRule()
    {
        $message = null;
        if (!Config::has('hcaptcha.empty_message')) {
            $message = Lang::get(Config::get('hcaptcha.error_message_key'));
        }
        Validator::extendImplicit('hcaptcha', function ($attribute, $value) {
            return $this->app->make(HCaptchaBuilder::class)->validate($value);
        }, $message);
    }

    /**
     * @return void
     */
    private function registerHCaptchaBuilder()
    {
        $this->app->singleton(HCaptchaBuilder::class, function () {
            return new HCaptchaBuilder(Config::get('hcaptcha.api_site_key'), Config::get('hcaptcha.api_secret_key'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [HCaptchaBuilder::class];
    }
}