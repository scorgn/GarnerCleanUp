<?php declare(strict_types=1);

namespace App\Services\SendInBlue;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use SendinBlue\Client\Configuration;

/**
 * Class SendInBlueServiceProvider
 */
class SendInBlueServiceProvider extends ServiceProvider
{
    /**
     * Register SendInBlue dependencies
     */
    public function register(): void
    {
        $this->app->bind(ClientInterface::class, Client::class);

        $this->app->singleton(
            Configuration::class,
            static fn ($app) => Configuration::getDefaultConfiguration()
                ->setApiKey('api-key', config('sendinblue.api-key')),
        );
    }
}
