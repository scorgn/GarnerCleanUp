<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\EventServiceInterface;

/**
 * Class HomepageController
 * @package App\Http\Controllers
 */
class HomepageController extends Controller
{
    /**
     * HomepageController constructor.
     * @param EventServiceInterface $eventbrite
     */
    public function __construct(private EventServiceInterface $eventbrite)
    { }

    /**
     * Return homepage view
     */
    public function __invoke()
    {
        $events = $this->eventbrite->getCurrentAndFutureEvents();

        return view('home', [
            'events' => $events,
        ]);
    }
}
