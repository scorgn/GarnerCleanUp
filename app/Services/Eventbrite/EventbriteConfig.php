<?php declare(strict_types=1);

namespace App\Services\Eventbrite;

/**
 * Class EventbriteAuthConfig
 * @package App\Services\Eventbrite
 */
class EventbriteConfig
{
    /**
     * EventbriteConfig constructor.
     * @param string $baseUrl
     * @param string $authUrl
     * @param string $apiKey
     * @param string $clientSecret
     * @param string $privateToken
     * @param string $publicToken
     * @param string $organizerId
     * @param string $organizationId
     */
    public function __construct(
        private string $baseUrl,
        private string $authUrl,
        private string $apiKey,
        private string $clientSecret,
        private string $privateToken,
        private string $publicToken,
        private string $organizerId,
        private string $organizationId,
    ) { }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getAuthUrl(): string
    {
        return $this->authUrl;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function getPrivateToken(): string
    {
        return $this->privateToken;
    }

    /**
     * @return string
     */
    public function getPublicToken(): string
    {
        return $this->publicToken;
    }

    /**
     * @return int
     */
    public function getOrganizerId(): int
    {
        return (int) $this->organizerId;
    }

    /**
     * @return int
     */
    public function getOrganizationId(): int
    {
        return (int) $this->organizationId;
    }
}
