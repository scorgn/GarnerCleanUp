<?php declare(strict_types=1);

namespace App\Services\Eventbrite\Factories;

use App\Services\Eventbrite\Models\Pagination;

/**
 * Class PaginationFactory
 * @package App\Services\Eventbrite\Factroies
 */
class PaginationFactory
{
    /**
     * @param array $parameters
     * @return Pagination
     */
    public function create(array $parameters): Pagination
    {
        return new Pagination(
            count: $parameters['object_count'],
            page: $parameters['page_number'],
            pageSize: $parameters['page_size'],
            pageCount: $parameters['page_count'],
            hasMoreItems: $parameters['has_more_items'],
        );
    }
}
