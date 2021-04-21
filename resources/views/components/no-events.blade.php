<?php
/** @var $event \App\Services\Eventbrite\Models\Event */
?>
<div class="event md:flex-row bg-white w-full text-center md:text-left shadow-2">
    <div class="event-image border-b-1 border-black">
        <img src="images/no-events.jpg" height="497" width="900" alt="Placeholder logo for no event" class="shadow-sharp ok">
    </div>
    <div class="px-5 pb-5 pt-2 flex flex-col lg:px-12">
        <div class="event-calendar-date flex flex-col shadow-2 text-center mx-auto w-full hidden md:visible">
{{--            <div class="event-month bg-red-800 text-gray-200 text-2xl py-1 px-7 font-light">{{ $event->getStartTime()->format('M') }}</div>--}}
{{--            <div class="event-day bg-gray-200 text-gray-900 text-2xl py-2 px-7 flex-grow my-auto flex items-center justify-center">{{ $event->getStartTime()->format('d') }}</div>--}}
        </div>
        <div class="event-contents flex flex-grow flex-col px-5 items-center mb-3 mt-0 md:my-3 text-left">
            <h3 class="text-2xl w-full py-2">{{ $hasEvent ? $event->getName() : "No Events Scheduled" }}</h3>
            <div class="block w-full py-2">
{{--                <p class="font-light py-1">{{ $event->eventTimeFormatted() }}</p>--}}
{{--                <p class="date-diff text-sm text-gray-700 font-light font-secondary">{{ $event->getStartTime()->diffForHumans() }}</p>--}}
            </div>
            <div class="block w-full py-3">
                <p class="font-secondary"></p>
            </div>
        </div>
        <div class="event-button py-3">
            <a href="javascript:void(0)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-9 rounded w-full flex justify-center">Subscribe</a>
        </div>
    </div>
</div>
