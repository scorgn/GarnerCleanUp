<?php declare(strict_types=1);

namespace App\Services\Eventbrite\Factories;

use App\Services\Eventbrite\Models\Event;
use Carbon\Carbon;

/**
 * Class EventFactory
 */
class EventFactory
{
    /**
     * EventFactory constructor.
     * @param LogoFactory $logoFactory
     */
    public function __construct(private LogoFactory $logoFactory)
    { }

    /**
     * @param array $parameters
     * @return Event
     */
    public function create(array $parameters): Event
    {
        return new Event(
            id: (int) $parameters['id'],
            name: $parameters['name']['text'],
            nameHtml: $parameters['name']['html'],
            url: $parameters['url'],
            description: $parameters['description']['text'],
            descriptionHtml: $parameters['description']['html'],
            startTime: Carbon::parse(
                $parameters['start']['local'],
                $parameters['start']['timezone']
            ),
            endTime: Carbon::parse(
                $parameters['end']['local'],
                $parameters['end']['timezone'],
            ),
            created: Carbon::parse($parameters['created']),
            updated: Carbon::parse($parameters['changed']),
            published: Carbon::parse($parameters['published']),
            status: $parameters['status'],
            logo: $this->logoFactory->create($parameters['logo']),
        );
    }
}
