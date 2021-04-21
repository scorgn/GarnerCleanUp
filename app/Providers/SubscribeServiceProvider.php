<?php
declare(strict_types=1);

namespace App\Providers;

use App\Services\Mailchimp\MailchimpConfig;
use App\Services\Mailchimp\MailchimpSubscribeService;
use App\Services\SubscribeServiceInterface;
use Carbon\Laravel\ServiceProvider;
use DrewM\MailChimp\MailChimp;

/**
 * Class SubscribeServiceProvider
 * @package App\Providers
 */
class SubscribeServiceProvider extends ServiceProvider
{
    /**
     * Register service bindings
     */
    public function register(): void
    {
        $this->app->bind(
            SubscribeServiceInterface::class,
            MailchimpSubscribeService::class
        );

        $this->app->singleton(
            MailChimp::class,
            static fn ($app) => new MailChimp(config('mailchimp.api-key'))
        );

        $this->app->singleton(
            MailchimpConfig::class,
            static fn ($app) => new MailchimpConfig(config('mailchimp.audience-id')),
        );
    }
}
