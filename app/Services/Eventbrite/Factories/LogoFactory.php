<?php declare(strict_types=1);

namespace App\Services\Eventbrite\Factories;

use App\Services\Eventbrite\Models\Logo;

/**
 * Class LogoFactory
 * @package App\Services\Eventbrite\Factroies
 */
class LogoFactory
{
    /**
     * @param array $arguments
     * @return Logo
     */
    public function create(array $arguments): Logo
    {
        return new Logo(
            id: (int) $arguments['id'],
            url: $arguments['original']['url'],
            height: $arguments['original']['height'],
            width: $arguments['original']['width'],
            aspectRatio: $arguments['aspect_ratio'],
            edgeColor: $arguments['edge_color'],
            edgeColorSet: $arguments['edge_color_set'],
        );
    }
}
