<?php declare(strict_types=1);

namespace App\Services\Eventbrite\Models;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

/**
 * Class Logo
 * @package App\Services\Eventbrite\Models
 */
#[Immutable] class Logo
{
    /**
     * Logo constructor.
     * @param int    $id
     * @param string $url
     * @param int    $height
     * @param int    $width
     * @param string $aspectRatio
     * @param string $edgeColor
     * @param bool   $edgeColorSet
     */
    public function __construct(
        private int $id,
        private string $url,
        private int $height,
        private int $width,
        private string $aspectRatio,
        private string $edgeColor,
        private bool $edgeColorSet,
    ) { }

    /**
     * @return int
     */
    #[Pure] public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    #[Pure] public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    #[Pure] public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    #[Pure] public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return string
     */
    #[Pure] public function getAspectRatio(): string
    {
        return $this->aspectRatio;
    }

    /**
     * @return string
     */
    #[Pure] public function getEdgeColor(): string
    {
        return $this->edgeColor;
    }

    /**
     * @return bool
     */
    #[Pure] public function isEdgeColorSet(): bool
    {
        return $this->edgeColorSet;
    }

}
