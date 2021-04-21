<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use App\Services\Eventbrite\Models\Event as EventModel;

/**
 * Class Event
 * @package App\View\Components
 */
class Event extends Component
{
    /**
     * Event constructor.
     * @param ?EventModel $event
     */
    public function __construct(public ?EventModel $event)
    { }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.event');
    }
}
