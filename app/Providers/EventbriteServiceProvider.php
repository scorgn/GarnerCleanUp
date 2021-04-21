<?php declare(strict_types=1);

namespace App\Providers;

use App\Services\Eventbrite\EventbriteAuth;
use App\Services\Eventbrite\EventbriteClient;
use App\Services\Eventbrite\EventbriteConfig;
use App\Services\Eventbrite\EventbriteEventService;
use App\Services\EventServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

/**
 * Class EventsServiceProvider
 * @package App\Providers
 */
class EventbriteServiceProvider extends ServiceProvider
{
    /**
     * Register service bindings
     */
    public function register(): void
    {
        $this->app->bind(EventServiceInterface::class, EventbriteEventService::class);
        $this->app->singleton(EventbriteConfig::class,
            fn ($app) => new EventbriteConfig(
                config('eventbrite.base_uri'),
                config('eventbrite.auth_url'),
                config('eventbrite.api_key'),
                config('eventbrite.client_secret'),
                config('eventbrite.private_token'),
                config('eventbrite.public_token'),
                config('eventbrite.organizer_id'),
                config('eventbrite.organization_id'),
            ));

        $this->app->when(EventbriteClient::class)
            ->needs(Client::class)
            ->give(static fn () => new Client([
                'base_uri' => config('eventbrite.base_uri')
            ]));

        $this->app->when(EventbriteClient::class)
            ->needs('$token')
            ->give(config('eventbrite.token'));
    }
}
