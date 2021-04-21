<?php declare(strict_types=1);

namespace App\Services\Eventbrite;

use GuzzleHttp\Client;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;

/**
 * Class EventbriteAuth
 * @package App\Services\Eventbrite
 */
class EventbriteAuth
{
    /**
     * EventbriteAuth constructor.
     * @param Client           $client
     * @param EventbriteConfig $config
     */
    public function __construct(
        private Client $client,
        private EventbriteConfig $config
    ) { }

    /**
     * @return string
     */
    #[Pure] public function createAuthorizeUrl(): string
    {
        return sprintf(
            $this->config->getBaseUrl(),
            $this->config->getClientKey()
        );
    }

    /**
     * @param string $code
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handshake(string $code): ResponseInterface
    {
        $formParams = [
            'code' => $code,
            'client_secret' => $this->config->getClientSecret(),
            'client_id' => $this->config->getAppKey(),
            'grant_type' => 'authorization_code'
        ];

        return $this->client->post('/token', [
            'form_params' => $formParams
        ]);
    }
}
