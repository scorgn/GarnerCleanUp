<?php declare(strict_types=1);

namespace App\Services\Eventbrite\Models;

use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

/**
 * Class Pagination
 * @package App\Services\Eventbrite\Models
 */
#[Immutable] class Pagination
{
    /**
     * EventsResponse constructor.
     * @param int        $count
     * @param int        $page
     * @param int        $pageSize
     * @param int        $pageCount
     * @param bool       $hasMoreItems
     */
    public function __construct(
        private int $count,
        private int $page,
        private int $pageSize,
        private int $pageCount,
        private bool $hasMoreItems,
    ) { }

    /**
     * @return int
     */
    #[Pure] public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    #[Pure] public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    #[Pure] public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    #[Pure] public function getPageCount(): int
    {
        return $this->pageCount;
    }

    /**
     * @return bool
     */
    #[Pure] public function hasMoreItems(): bool
    {
        return $this->hasMoreItems;
    }
}
