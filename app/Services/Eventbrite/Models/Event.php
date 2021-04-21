<?php declare(strict_types=1);

namespace App\Services\Eventbrite\Models;

use Carbon\Carbon;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

/**
 * Class Event
 */
#[Immutable] class Event
{
    private const TIME_ONLY_FORMAT = 'g:iA';
    private const DATE_AND_TIME_WITHOUT_YEAR_FORMAT = 'D, M d g:iA';
    private const DATE_AND_TIME_WITH_YEAR_FORMAT = 'D, M d, Y g:iA';

    /**
     * Event constructor.
     * @param int    $id
     * @param string $name
     * @param string $nameHtml
     * @param string $url
     * @param string $description
     * @param string $descriptionHtml
     * @param Carbon $startTime
     * @param Carbon $endTime
     * @param Carbon $created
     * @param Carbon $updated
     * @param Carbon $published
     * @param string $status
     * @param Logo   $logo
     */
    public function __construct(
        private int $id,
        private string $name,
        private string $nameHtml,
        private string $url,
        private string $description,
        private string $descriptionHtml,
        private Carbon $startTime,
        private Carbon $endTime,
        private Carbon $created,
        private Carbon $updated,
        private Carbon $published,
        private string $status,
        private Logo $logo,
    ) { }

    #[Pure] public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    #[Pure] public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    #[Pure] public function getNameHtml(): string
    {
        return $this->nameHtml;
    }

    /**
     * @return string
     */
    #[Pure] public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    #[Pure] public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    #[Pure] public function getDescriptionHtml(): string
    {
        return $this->descriptionHtml;
    }

    /**
     * @return Carbon
     */
    #[Pure] public function getStartTime(): Carbon
    {
        return $this->startTime;
    }

    /**
     * @return Carbon
     */
    #[Pure] public function getEndTime(): Carbon
    {
        return $this->endTime;
    }

    /**
     * @return Carbon
     */
    #[Pure] public function getCreated(): Carbon
    {
        return $this->created;
    }

    /**
     * @return Carbon
     */
    #[Pure] public function getUpdated(): Carbon
    {
        return $this->updated;
    }

    /**
     * @return Carbon
     */
    #[Pure] public function getPublished(): Carbon
    {
        return $this->published;
    }

    /**
     * @return string
     */
    #[Pure] public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return Logo
     */
    #[Pure] public function getLogo(): Logo
    {
        return $this->logo;
    }

    /**
     * @return string
     */
    #[Pure] public function eventTimeFormatted(): string
    {
        return sprintf(
            '%s - %s',
            $this->getStartTimeString(),
            $this->getEndTimeString()
        );
    }

    /**
     * @return string
     */
    #[Pure] private function getStartTimeString(): string
    {
        return $this->startTime->isCurrentYear()
            ? $this->startTime->format(self::DATE_AND_TIME_WITHOUT_YEAR_FORMAT)
            : $this->startTime->format(self::DATE_AND_TIME_WITH_YEAR_FORMAT);
    }

    /**
     * @return string
     */
    #[Pure] private function getEndTimeString(): string
    {
        if ($this->endTime->isSameDay($this->startTime)) {
            return $this->endTime->format(self::TIME_ONLY_FORMAT);
        }

        return $this->endTime->isCurrentYear()
            ? $this->endTime->format(self::DATE_AND_TIME_WITHOUT_YEAR_FORMAT)
            : $this->endTime->format(self::DATE_AND_TIME_WITH_YEAR_FORMAT);
    }
}
