<?php
    /** @var $event \App\Services\Eventbrite\Models\Event */
    $hasEvent = isset($event);
?>
<div class="event flex flex-col xl:flex-row bg-white w-full text-center md:text-left shadow-2">
    <div class="event-image border-b-1 border-black">
        @if($hasEvent)
            <img src="{{ $event->getLogo()->getUrl() }}" height="{{ $event->getLogo()->getHeight() }}" width="{{ $event->getLogo()->getWidth() }}" alt="Logo for event {{ $event->getName() }}" class="shadow-sharp object-cover xl:max-w-420px xl:h-full">
        @else
            <img src="images/no-events.jpg" height="497" width="900" alt="Placeholder logo for no event" class="shadow-sharp ok">
        @endif
    </div>
    <div class="px-5 pb-5 pt-2 flex flex-col lg:px-12">
        @if($hasEvent)
            <div class="event-calendar-date flex flex-col shadow-2 text-center mx-auto w-full hidden md:visible">
                <div class="event-month bg-red-800 text-gray-200 text-2xl py-1 px-7 font-light">{{ $event->getStartTime()->format('M') }}</div>
                <div class="event-day bg-gray-200 text-gray-900 text-2xl py-2 px-7 flex-grow my-auto flex items-center justify-center">{{ $event->getStartTime()->format('d') }}</div>
            </div>
        @endif
        <div class="event-contents flex flex-grow flex-col px-5 items-center mb-3 mt-0 md:my-3 text-left">
            <h3 class="text-2xl w-full py-2 xl:pt-0">{{ $hasEvent ? $event->getName() : "No Events Scheduled" }}</h3>
            @if($hasEvent)
                <div class="block w-full py-2">
                    <p class="font-light py-1">{{ $event->eventTimeFormatted() }}</p>
                    <p class="date-diff text-sm text-gray-700 font-light font-secondary">{{ $event->getStartTime()->diffForHumans() }}</p>
                </div>
            @endif
            <div class="block w-full py-3">
                <p class="font-secondary">{{ $hasEvent ? $event->getDescription() : "It looks like there isn't currently a trash pickup event scheduled, but there will be soon! Subscribe to our events to keep up to date with future events."}}</p>
            </div>
        </div>
        <div class="event-button py-3">
            <a href="{{ $hasEvent ? $event->getUrl() : "javascript:void(0)" }}" id="{{ $hasEvent ? "registerEvent" : "scrollToSubscribe" }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-9 rounded w-full flex justify-center transition-colors">{{ $hasEvent ? "Register" : "Subscribe" }}</a>
        </div>
    </div>
</div>
