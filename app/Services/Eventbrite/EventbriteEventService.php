<?php declare(strict_types=1);

namespace App\Services\Eventbrite;

use App\Services\Eventbrite\Factories\EventsResponseFactory;
use App\Services\Eventbrite\Models\EventsResponse;
use App\Services\EventServiceInterface;
use Illuminate\Support\Collection;

/**
 * Interface EventbriteEventService
 * @package App\Services
 */
class EventbriteEventService implements EventServiceInterface
{
    /**
     * EventbriteEventService constructor.
     * @param EventbriteSdk    $eventbrite
     * @param EventbriteConfig $config
     * @param EventsResponseFactory $eventsResponseFactory
     */
    public function __construct(
        private EventbriteSdk $eventbrite,
        private EventbriteConfig $config,
        private EventsResponseFactory $eventsResponseFactory
    ) { }

    /**
     * @return EventsResponse
     */
    public function getCurrentAndFutureEvents(): EventsResponse
    {
        $eventParameters = $this->eventbrite->getOrganizationsEvents(
            $this->config->getOrganizationId(),
            [],
            [
                'time_filter' => 'current_future',
                'order_by' => 'start_asc',
                'page_size' => 1
            ],
        );

        return $this->eventsResponseFactory->create($eventParameters);
    }
}
