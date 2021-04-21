<?php declare(strict_types=1);

namespace App\Services\Eventbrite\Models;

use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

/**
 * Class EventsResponse
 * @package App\Services\Eventbrite\Models
 */
#[Immutable] class EventsResponse
{
    /**
     * EventsResponse constructor.
     * @param Pagination $pagination
     * @param Collection $items
     */
    public function __construct(
        private Pagination $pagination,
        private Collection $items,
    ) { }

    /**
     * @return Pagination
     */
    #[Pure] public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    /**
     * @return Collection
     */
    #[Pure] public function getItems(): Collection
    {
        return $this->items;
    }
}
