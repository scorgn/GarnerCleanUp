<?php declare(strict_types=1);

namespace App\Services\Eventbrite\Factories;

use App\Services\Eventbrite\Models\EventsResponse;

/**
 * Class EventsResponseFactory
 * @package App\Services\Eventbrite\Factroies
 */
class EventsResponseFactory
{
    /**
     * EventsResponseFactory constructor.
     * @param PaginationFactory $paginationFactory
     * @param EventFactory      $eventFactory
     */
    public function __construct(
        private PaginationFactory $paginationFactory,
        private EventFactory $eventFactory,
    ) { }

    /**
     * @param array $arguments
     * @return EventsResponse
     */
    public function create(array $arguments): EventsResponse
    {
        return new EventsResponse(
            pagination:  $this->paginationFactory->create($arguments['pagination']),
            items: collect($arguments['events'])->map(
                fn ($eventArguments) => $this->eventFactory->create($eventArguments)
            ),
        );
    }
}
