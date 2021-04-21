<?php declare(strict_types=1);

namespace App\Services\Eventbrite;

use InvalidArgumentException;
use ReflectionClass;

/**
 * Class EventbriteEndpoints
 * @package App\Services\Eventbrite
 *
 * @method categories(): string
 * @method category(int $categoryId): string
 * @method event(int $eventId): string
 * @method eventAccessCode(int $eventId, int $accessCodeId): string
 * @method eventAccessCodes(int $eventId): string
 * @method eventAttendee(int $eventId, int $attendeeId): string
 * @method eventAttendees(int $eventId): string
 * @method eventCancel(int $eventId): string
 * @method eventCannedQuestions(int $eventId): string
 * @method eventDiscount(int $eventId, int $discountId): string
 * @method eventDiscounts(int $eventId): string
 * @method eventDisplaySettings(int $eventId): string
 * @method eventOrders(int $eventId): string
 * @method eventPublicDiscount(int $eventId, int $discountId): string
 * @method eventPublicDiscounts(int $eventId): string
 * @method eventPublish(int $eventId): string
 * @method eventQuestion(int $eventId, int $questionId): string
 * @method eventQuestions(int $eventId): string
 * @method events(): string
 * @method eventSearch(): string
 * @method eventTeam(int $eventId, int $teamId): string
 * @method eventTeams(int $eventId): string
 * @method eventTeamsAttendees(int $eventId, int $teamId): string
 * @method eventTicketClass(int $eventId, int $ticketClassId): string
 * @method eventTicketClasses(int $eventId): string
 * @method eventTrackingBeacons(int $eventId): string
 * @method eventTransfers(int $eventId): string
 * @method eventUnpublish(int $eventId): string
 * @method formats(int $formatId): string
 * @method formatss(): string
 * @method media(int $id): string
 * @method mediaUpload(): string
 * @method oneSeries(int $seriesId): string
 * @method order(int $orderId): string
 * @method organizer(int $organizerId): string
 * @method organizers(): string
 * @method organizersEvents(int $organizerId): string
 * @method organizations(): string
 * @method organization(int $organizationId): string
 * @method organizationsEvents(int $organizationId): string
 * @method refundRequest(int $refundRequestId): string
 * @method refundRequests(): string
 * @method reportsAttendees(): string
 * @method reportsSales(): string
 * @method series(): string
 * @method seriesCancel(int $seriesId): string
 * @method seriesEvents(int $seriesId): string
 * @method seriesPublish(int $seriesId): string
 * @method seriesUnpublish(int $seriesId): string
 * @method subcategories(): string
 * @method subcategory(int $subcategoryId): string
 * @method systemCountries(): string
 * @method systemRegions(): string
 * @method systemTimezones(): string
 * @method trackingBeacon(int $trackingBeaconsId): string
 * @method trackingBeacons(): string
 * @method user(int $userId): string
 * @method userBookmarks(int $userId): string
 * @method userBookmarksSave(int $userId): string
 * @method userBookmarksUnsave(int $userId): string
 * @method userContactList(int $userId, int $contactListId): string
 * @method userContactLists(int $userId): string
 * @method userContactListsContacts(int $userId, int $contactListId): string
 * @method userEvents(int $userId): string
 * @method userOrders(int $userId): string
 * @method userOrganizers(int $userId): string
 * @method userOwnedEventAttendees(int $userId): string
 * @method userOwnedEventOrders(int $userId): string
 * @method userOwnedEvents(int $userId): string
 * @method userTrackingBeacons(int $userId): string
 * @method userVenues(int $userId): string
 * @method venue(int $venueId): string
 * @method venues(): string
 * @method venuesEvents(int $venueId): string
 * @method venuesSearch(): string
 * @method webhook(int $webhookId): string
 * @method webhooks(): string
 */
class EventbriteEndpoints
{
    public const CATEGORIES = "categories/";
    public const CATEGORY = "categories/%s/";
    public const EVENT = "events/%s/";
    public const EVENT_ACCESS_CODE = "events/%s/access_codes/%s/";
    public const EVENT_ACCESS_CODES = "events/%s/access_codes/";
    public const EVENT_ATTENDEE = "events/%s/attendees/%s/";
    public const EVENT_ATTENDEES = "events/%s/attendees/";
    public const EVENT_CANCEL = "events/%s/cancel/";
    public const EVENT_CANNED_QUESTIONS = "events/%s/canned_questions/";
    public const EVENT_DISCOUNT = "events/%s/discounts/%s/";
    public const EVENT_DISCOUNTS = "events/%s/discounts/";
    public const EVENT_DISPLAY_SETTINGS = "events/%s/display_settings/";
    public const EVENT_ORDERS = "events/%s/orders/";
    public const EVENT_PUBLIC_DISCOUNT = "events/%s/public_discounts/%s/";
    public const EVENT_PUBLIC_DISCOUNTS = "events/%s/public_discounts/";
    public const EVENT_PUBLISH = "events/%s/publish/";
    public const EVENT_QUESTION = "events/%s/questions/%s/";
    public const EVENT_QUESTIONS = "events/%s/questions/";
    public const EVENTS = "events/";
    public const EVENT_SEARCH = "events/search";
    public const EVENT_TEAM = "events/%s/teams/%s/";
    public const EVENT_TEAMS = "events/%s/teams/";
    public const EVENT_TEAMS_ATTENDEES = "events/%s/teams/%s/attendees/";
    public const EVENT_TICKET_CLASS = "events/%s/ticket_classes/%s/";
    public const EVENT_TICKET_CLASSES = "events/%s/ticket_classes/";
    public const EVENT_TRACKING_BEACONS = "events/%s/tracking_beacons/";
    public const EVENT_TRANSFERS = "events/%s/transfers/";
    public const EVENT_UNPUBLISH = "events/%s/unpublish/";
    public const FORMAT = "formats/%s/";
    public const FORMATS = "formats/";
    public const MEDIA = "media/%s/";
    public const MEDIA_UPLOAD = "media/upload/";
    public const ONE_SERIES = "series/%s/";
    public const ORDER = "orders/%s/";
    public const ORGANIZER = "organizers/%s/";
    public const ORGANIZERS = "organizers/";
    public const ORGANIZERS_EVENTS = "organizers/%s/events/";
    public const ORGANIZATION = "organizations/%s/";
    public const ORGANIZATIONS = "organizations/";
    public const ORGANIZATIONS_EVENTS = "organizations/%s/events/";
    public const REFUND_REQUEST = "refund_requests/%s/";
    public const REFUND_REQUESTS = "refund_requests/";
    public const REPORTS_ATTENDEES = "reports/attendees/";
    public const REPORTS_SALES = "reports/sales/";
    public const SERIES = "series/";
    public const SERIES_CANCEL = "series/%s/cancel/";
    public const SERIES_EVENTS = "series/%s/events/";
    public const SERIES_PUBLISH = "series/%s/publish/";
    public const SERIES_UNPUBLISH = "series/%s/unpublish/";
    public const SUBCATEGORIES = "subcategories/";
    public const SUBCATEGORY = "subcategories/%s/";
    public const SYSTEM_COUNTRIES = "system/countries/";
    public const SYSTEM_REGIONS = "system/regions/";
    public const SYSTEM_TIMEZONES = "system/timezones/";
    public const TRACKING_BEACON = "tracking_beacons/%s/";
    public const TRACKING_BEACONS = "tracking_beacons/";
    public const USER = "users/%s/";
    public const USER_BOOKMARKS = "users/%s/bookmarks/";
    public const USER_BOOKMARKS_SAVE = "users/%s/bookmarks/save/";
    public const USER_BOOKMARKS_UNSAVE = "users/%s/bookmarks/unsave/";
    public const USER_CONTACT_LIST = "users/%s/contact_lists/%s/";
    public const USER_CONTACT_LISTS = "users/%s/contact_lists/";
    public const USER_CONTACT_LISTS_CONTACTS = "users/%s/contact_lists/%s/contacts/";
    public const USER_EVENTS = "users/%s/events/";
    public const USER_ORDERS = "users/%s/orders/";
    public const USER_ORGANIZERS = "users/%s/organizers/";
    public const USER_OWNED_EVENT_ATTENDEES = "users/%s/owned_event_attendees/";
    public const USER_OWNED_EVENT_ORDERS = "users/%s/owned_event_orders/";
    public const USER_OWNED_EVENTS = "users/%s/owned_events/";
    public const USER_TRACKING_BEACONS = "users/%s/tracking_beacons/";
    public const USER_VENUES = "users/%s/venues/";
    public const VENUE = "venues/%s/";
    public const VENUES = "venues/";
    public const VENUES_EVENTS = "venues/%s/events/";
    public const VENUES_SEARCH = "venues/search/";
    public const WEBHOOK = "webhooks/%s/";
    public const WEBHOOKS = "webhooks/";

    /**
     * @param string $name
     * @param array  $arguments
     * @return string
     */
    public static function __callStatic(string $name, array $arguments): string
    {
        $constant = strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        $class = new ReflectionClass(static::class);
        $route = $class->getConstant($constant);

        if (!$route) {
            throw new InvalidArgumentException(sprintf("There is no route defined as %s", $name));
        }

        return vsprintf($route, $arguments);
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return string
     */
    public function __call(string $name, array $arguments): string
    {
        return self::__callStatic($name, $arguments);
    }

}
