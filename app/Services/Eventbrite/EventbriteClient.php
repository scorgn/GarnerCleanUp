<?php declare(strict_types=1);

namespace App\Services\Eventbrite;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\array;
use Illuminate\Cache\Repository as Cache;

/**
 * Http client used to perform requests on Eventbrite API.
 */
class EventbriteClient
{
    /**
     * User agent
     */
    private const USER_AGENT = 'eventbrite-sdk-php';

    /**
     * EventbriteClient constructor.
     * @param Client           $client
     * @param EventbriteConfig $config
     * @param Cache            $cache
     */
    public function __construct(
        private Client $client,
        private EventbriteConfig $config,
        private Cache $cache,
    ) { }

    /**
     * @param string $uri
     * @param array  $body
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $body = []): array
    {
        return $this->request('POST', $uri, $body);
    }

    /**
     * @param string $uri
     * @param array  $expand
     * @param array  $queryParameters
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(
        string $uri,
        array $expand = [],
        array $queryParameters = []
    ): array {
        return $this->requestCached('GET', $uri, null, $queryParameters, $expand);
    }

    /**
     * @param string $uri
     * @param array  $body
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $uri, array $body = []): array
    {
        return $this->request('DELETE', $uri, $body);
    }

    /**
     * @param string            $method
     * @param string            $uri
     * @param array|string|null $body
     * @param array             $queryParameters
     * @param array|null        $expand
     * @param array             $options
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(
        string $method,
        $uri = '',
        array|string $body = null,
        array $queryParameters = [],
        array $expand = null,
        array $options = []
    ): array {
        $defaultQueryParameters = ['token' => $this->config->getPrivateToken()];

        if ($expand) {
            $defaultQueryParameters['expand'] = implode(",", $expand);
        }

        $options['query'] = array_merge($defaultQueryParameters, $queryParameters);
        $options['headers']['User-Agent'] = self::USER_AGENT;

        if ($body && is_array($body)) {
            $options['json'] = $body;
        } elseif ($body && is_string($body)) {
            $options['body'] = $body;
        }

        $request = $this->client->request($method, $uri, $options);

        return json_decode(
            $request->getBody()->getContents(),
            true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param string            $method
     * @param string            $uri
     * @param array|string|null $body
     * @param array             $queryParameters
     * @param array|null        $expand
     * @param array             $options
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestCached(
        string $method,
        $uri = '',
        array|string $body = null,
        array $queryParameters = [],
        array $expand = null,
        array $options = []
    ): array {
        $cacheKey = $this->getCacheKey(
            $method,
            $uri,
            $body,
            $queryParameters,
            $expand,
            $options
        );

        if ($this->cache->has($cacheKey)) {
            return unserialize($this->cache->get($cacheKey), [
                'allowed_classes' => false,
            ]);
        }

        $response = $this->request(
            $method,
            $uri,
            $body,
            $queryParameters,
            $expand,
            $options
        );

        $this->cache->put(
            $cacheKey,
            serialize($response),
            Carbon::now()->addHours(6)
        );

        return $response;
    }

    /**
     * @param string            $method
     * @param string            $uri
     * @param array|string|null $body
     * @param array             $queryParameters
     * @param array|null        $expand
     * @param array             $options
     * @return string
     */
    private function getCacheKey(
        string $method,
        $uri = '',
        array|string $body = null,
        array $queryParameters = [],
        array $expand = null,
        array $options = []
    ): string {
        if (is_array($body)) {
            $this->sortArray($body);
        }

        if ($expand) {
            $this->sortArray($expand);
        }

        $this->sortArray($queryParameters);
        $this->sortArray($options);

        $cacheKeyArray = [
            'method' => $method,
            'uri' => $uri,
            'body' => $body,
            'expand' => $expand,
            'query' => $queryParameters,
        ];

        return md5(serialize($cacheKeyArray));
    }

    /**
     * Sort multidimensional associative array for key normalization
     *
     * @param array $array
     */
    private function sortArray(array &$array)
    {
        asort($array);
        foreach ($array as $key => $element) {
            if (is_array($element)) {
                $this->sortArray($array[$key]);
            }
        }
    }
}
