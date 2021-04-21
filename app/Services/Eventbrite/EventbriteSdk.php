<?php declare(strict_types=1);

namespace App\Services\Eventbrite;

use Psr\Http\Message\array;

/**
 * Class EventbriteSdk
 * @package App\Services\Eventbrite
 */
class EventbriteSdk
{
    /**
     * EventbriteSdk constructor.
     * @param EventbriteClient    $client
     * @param EventbriteEndpoints $endpoints
     */
    public function __construct(
        private EventbriteClient $client,
        private EventbriteEndpoints $endpoints,
    ) { }

    /**
     * get_categories
     * GET /categories/
     *        Returns a list of :format:`category` as ``categories``, including
     *        subcategories nested.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCategories(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->categories(), $expand, $query_params);
    }

    /**
     * get_category
     * GET /categories/:id/
     *        Gets a :format:`category` by ID as ``category``.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCategory(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->category($id), $expand, $query_params);
    }

    /**
     * get_subcategories
     * GET /subcategories/
     *        Returns a list of :format:`subcategory` as ``subcategories``.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubcategories(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->subcategories(), $expand, $query_params);
    }

    /**
     * get_subcategory
     * GET /subcategories/:id/
     *        Gets a :format:`subcategory` by ID as ``subcategory``.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubcategory(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->subcategory($id), $expand, $query_params);
    }

    /**
     * get_event_search
     * GET /events/search/
     *        Allows you to retrieve a paginated response of public :format:`event` objects from across Eventbrite’s
     *        directory, regardless of which user owns the event.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventSearch(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->eventSearch(), $expand, $query_params);
    }

    /**
     * post_events
     * POST /events/
     *        Makes a new event, and returns an :format:`event` for the specified event. Does not support the creation
     *        of repeating event series. field event.venue_id The ID of a previously-created venue to associate with
     *        this event. You can omit this field or set it to ``null`` if you set ``online_event``.
     *
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEvents(array $data = []): array
    {
        return $this->client->post($this->endpoints->events(), $data);
    }

    /**
     * get_event
     * GET /events/:id/
     *        Returns an :format:`event` for the specified event. Many of Eventbrite’s API use cases revolve around
     *        pulling details of a specific event within an Eventbrite account. Does not support fetching a repeating
     *        event series parent
     *        (see :ref:`get-series-by-id`).
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEvent(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->event($id), $expand, $query_params);
    }

    /**
     * post_event
     * POST /events/:id/
     *        Updates an event. Returns an :format:`event` for the specified event. Does not support updating a
     *        repeating event series parent (see POST /series/:id/).
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEvent(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->event($id), $data);
    }

    /**
     * post_event_publish
     * POST /events/:id/publish/
     *        Publishes an event if it has not already been deleted. In order for publish to be permitted, the event
     *        must have all necessary information, including a name and description, an organizer, at least one ticket,
     *        and valid payment options. This API endpoint will return argument errors for event fields that fail to
     *        validate the publish requirements. Returns a boolean indicating success or failure of the publish.
     *        field_error event.name MISSING Your event must have a name to be published. field_error event.start
     *        MISSING Your event must have a start date to be published. field_error event.end MISSING Your event must
     *        have an end date to be published. field_error event.start.timezone MISSING Your event start and end dates
     *        must have matching time zones to be published. field_error event.organizer MISSING Your event must have
     *        an organizer to be published. field_error event.currency MISSING Your event must have a currency to be
     *        published. field_error event.currency INVALID Your event must have a valid currency to be published.
     *        field_error event.tickets MISSING Your event must have at least one ticket to be published. field_error event.tickets.N.name MISSING All tickets must have names in order for your event to be published. The N will be the ticket class ID with the error. field_error event.tickets.N.quantity_total MISSING All non-donation tickets must have an available quantity value in order for your event to be published. The N will be the ticket class ID with the error. field_error event.tickets.N.cost MISSING All non-donation tickets must have a cost (which can be ``0.00`` for free tickets) in order for your event to be published. The N will be the ticket class ID with the error.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventPublish(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventPublish($id), $data);
    }

    /**
     * post_event_unpublish
     * POST /events/:id/unpublish/
     *        Unpublishes an event. In order for a free event to be unpublished, it must not have any pending or
     *        completed orders, even if the event is in the past. In order for a paid event to be unpublished, it must
     *        not have any pending or completed orders, unless the event has been completed and paid out. Returns a
     *        boolean indicating success or failure of the unpublish.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventUnpublish(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventUnpublish($id), $data);
    }

    /**
     * post_event_cancel
     * POST /events/:id/cancel/
     *        Cancels an event if it has not already been deleted. In order for cancel to be permitted, there must be
     *        no pending or completed orders. Returns a boolean indicating success or failure of the cancel.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventCancel(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventCancel($id), $data);
    }

    /**
     * delete_event
     * DELETE /events/:id/
     *        Deletes an event if the delete is permitted. In order for a delete to be permitted, there must be no
     *        pending or completed orders. Returns a boolean indicating success or failure of the delete.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteEvent(int $id, array $data = []): array
    {
        return $this->client->delete($this->endpoints->event($id), $data);
    }

    /**
     * get_event_display_settings
     * GET /events/:id/display_settings/
     *        Retrieves the display settings for an event.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventDisplaySettings(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventDisplaySettings($id),
            $expand,
            $query_params
        );
    }

    /**
     * post_event_display_settings
     * POST /events/:id/display_settings/
     *        Updates the display settings for an event.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventDisplaySettings(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventDisplaySettings($id), $data);
    }

    /**
     * get_event_ticket_classes
     * GET /events/:id/ticket_classes/
     *        Returns a :ref:`paginated <pagination>` response with a key of
     *        ``ticket_classes``, containing a list of :format:`ticket_class`.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventTicketClasses(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventTicketClasses($id),
            $expand,
            $query_params
        );
    }

    /**
     * post_event_ticket_classes
     * POST /events/:id/ticket_classes/
     *        Creates a new ticket class, returning the result as a :format:`ticket_class`
     *        under the key ``ticket_class``.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventTicketClasses(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventTicketClasses($id), $data);
    }

    /**
     * get_event_ticket_class
     * GET /events/:id/ticket_classes/:ticket_class_id/
     *        Gets and returns a single :format:`ticket_class` by ID, as the key
     *        ``ticket_class``.
     *
     * @param int   $id
     * @param       $ticket_class_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventTicketClass(
        int $id,
        $ticket_class_id,
        array $expand = [],
        array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventTicketClass($id, $ticket_class_id),
            $expand,
            $query_params
        );
    }

    /**
     * post_event_ticket_class
     * POST /events/:id/ticket_classes/:ticket_class_id/
     *        Updates an existing ticket class, returning the updated result as a :format:`ticket_class` under the key
     *        ``ticket_class``.
     *
     * @param int   $id
     * @param       $ticket_class_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventTicketClass(int $id, $ticket_class_id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventTicketClass($id, $ticket_class_id), $data);
    }

    /**
     * delete_event_ticket_class
     * DELETE /events/:id/ticket_classes/:ticket_class_id/
     *        Deletes the ticket class. Returns ``{"deleted": true}``.
     *
     * @param int   $id
     * @param       $ticket_class_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteEventTicketClass(int $id, $ticket_class_id, array $data = []): array
    {
        return $this->client->delete(
            $this->endpoints->eventTicketClass($id, $ticket_class_id),
            $data
                = $data
        );
    }

    /**
     * get_event_canned_questions
     * GET /events/:id/canned_questions/
     *        This endpoint returns canned questions of a single event (examples: first name, last name, company,
     *        prefix, etc.). This endpoint will return :format:`question`.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventCannedQuestions(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventCannedQuestions($id),
            $expand,
            $query_params
        );
    }

    /**
     * get_event_questions
     * GET /events/:id/questions/
     *        Eventbrite allows event organizers to add custom questions that attendees fill
     *        out upon registration. This endpoint can be helpful for determining what
     *        custom information is collected and available per event.
     *        This endpoint will return :format:`question`.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventQuestions(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->eventQuestions($id), $expand, $query_params);
    }

    /**
     * get_event_question
     * GET /events/:id/questions/:question_id/
     *        This endpoint will return :format:`question` for a specific question id.
     *
     * @param int   $id
     * @param       $question_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventQuestion(
        int $id,
        $question_id,
        array $expand = [],
        array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventQuestion($id, $question_id),
            $expand,
            $query_params
        );
    }

    /**
     * get_event_attendees
     * GET /events/:id/attendees/
     *        Returns a :ref:`paginated <pagination>` response with a key of ``attendees``, containing a list of
     *        :format:`attendee`.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventAttendees(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->eventAttendees($id), $expand, $query_params);
    }

    /**
     * get_event_attendee
     * GET /events/:id/attendees/:attendee_id/
     *        Returns a single :format:`attendee` by ID, as the key ``attendee``.
     *
     * @param int   $id
     * @param       $attendee_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventAttendee(
        int $id,
        $attendee_id,
        array $expand = [],
        array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventAttendee($id, $attendee_id),
            $expand,
            $query_params
        );
    }

    /**
     * get_event_orders
     * GET /events/:id/orders/
     *        Returns a :ref:`paginated <pagination>` response with a key of ``orders``, containing a list of
     *        :format:`order` against this event.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventOrders(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->eventOrders($id), $expand, $query_params);
    }

    /**
     * get_event_discounts
     * GET /events/:id/discounts/
     *        Returns a :ref:`paginated <pagination>` response with a key of ``discounts``,
     *        containing a list of :format:`discounts <discount>` available on this event.
     *        field_error event_id NOT_FOUND
     *        The event id you are attempting to use does not exist.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventDiscounts(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->eventDiscounts($id), $expand, $query_params);
    }

    /**
     * post_event_discounts
     * POST /events/:id/discounts/
     *        Creates a new discount; returns the result as a :format:`discount` as the key ``discount``.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventDiscounts(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventDiscounts($id), $data);
    }

    /**
     * get_event_discount
     * GET /events/:id/discounts/:discount_id/
     *        Gets a :format:`discount` by ID as the key ``discount``.
     *
     * @param int   $id
     * @param       $discount_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventDiscount(
        int $id,
        $discount_id,
        array $expand = [],
        array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventDiscount($id, $discount_id),
            $expand,
            $query_params
        );
    }

    /**
     * post_event_discount
     * POST /events/:id/discounts/:discount_id/
     *        Updates a discount; returns the result as a :format:`discount` as the key ``discount``.
     *
     * @param int   $id
     * @param       $discount_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventDiscount(int $id, $discount_id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventDiscount($id, $discount_id), $data);
    }

    /**
     * get_event_public_discounts
     * GET /events/:id/public_discounts/
     *        Returns a :ref:`paginated <pagination>` response with a key of ``discounts``, containing a list of public
     *        :format:`discounts <discount>` available on this event. Note that public discounts and discounts have
     *        exactly the same form and structure; they're just namespaced separately, and public ones (and the public
     *        GET endpoints) are visible to anyone who can see the event.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventPublicDiscounts(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventPublicDiscounts($id),
            $expand,
            $query_params
        );
    }

    /**
     * post_event_public_discounts
     * POST /events/:id/public_discounts/
     *        Creates a new public discount; returns the result as a :format:`discount` as the key ``discount``.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventPublicDiscounts(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventPublicDiscounts($id), $data);
    }

    /**
     * get_event_public_discount
     * GET /events/:id/public_discounts/:discount_id/
     *        Gets a public :format:`discount` by ID as the key ``discount``.
     *
     * @param int   $id
     * @param       $discount_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventPublicDiscount(
        int $id,
        $discount_id,
        array $expand = [],
        array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventPublicDiscount($id, $discount_id),
            $expand,
            $query_params
        );
    }

    /**
     * post_event_public_discount
     * POST /events/:id/public_discounts/:discount_id/
     *        Updates a public discount; returns the result as a :format:`discount` as the key ``discount``.
     *
     * @param int   $id
     * @param       $discount_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventPublicDiscount(int $id, $discount_id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventPublicDiscount($id, $discount_id), $data);
    }

    /**
     * delete_event_public_discount
     * DELETE /events/:id/public_discounts/:discount_id/
     *        Deletes a public discount.
     *
     * @param int   $id
     * @param       $discount_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteEventPublicDiscount(int $id, $discount_id, array $data = []): array
    {
        return $this->client->delete($this->endpoints->eventPublicDiscount($id, $discount_id), $data);
    }

    /**
     * get_event_access_codes
     * GET /events/:id/access_codes/
     *        Returns a :ref:`paginated <pagination>` response with a key of ``access_codes``, containing a list of
     *        :format:`access_codes <access_code>` available on this event.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventAccessCodes(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventAccessCodes($id),
            $expand,
            $query_params
        );
    }

    /**
     * post_event_access_codes
     * POST /events/:id/access_codes/
     *        Creates a new access code; returns the result as a :format:`access_code` as the key ``access_code``.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventAccessCodes(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventAccessCodes($id), $data);
    }

    /**
     * get_event_access_code
     * GET /events/:id/access_codes/:access_code_id/
     *        Gets a :format:`access_code` by ID as the key ``access_code``.
     *
     * @param int   $id
     * @param       $access_code_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventAccessCode(
        int $id,
        $access_code_id,
        array $expand = [],
        array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventAccessCode($id, $access_code_id),
            $expand,
            $query_params
        );
    }

    /**
     * post_event_access_code
     * POST /events/:id/access_codes/:access_code_id/
     *        Updates an access code; returns the result as a :format:`access_code` as the
     *        key ``access_code``.
     *
     * @param int   $id
     * @param       $access_code_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postEventAccessCode(int $id, $access_code_id, array $data = []): array
    {
        return $this->client->post($this->endpoints->eventAccessCode($id, $access_code_id), $data);
    }

    /**
     * get_event_transfers
     * GET /events/:id/transfers/
     *        Returns a list of :format:`transfers` for the event.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventTransfers(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->eventTransfers($id), $expand, $query_params);
    }

    /**
     * get_event_teams
     * GET /events/:id/teams/
     *        Returns a list of :format:`teams` for the event.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventTeams(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->eventTeams($id), $expand, $query_params);
    }

    /**
     * get_event_team
     * GET /events/:id/teams/:team_id/
     *        Returns information for a single :format:`teams`.
     *
     * @param int   $id
     * @param       $team_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventTeam(int $id, $team_id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventTeam($id, $team_id),
            $expand,
            $query_params
        );
    }

    /**
     * get_event_teams_attendees
     * GET /events/:id/teams/:team_id/attendees/
     *        Returns :format:`attendees` for a single :format:`teams`.
     *
     * @param int   $id
     * @param       $team_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventTeamsAttendees(
        int $id,
        $team_id,
        array $expand = [],
        array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventTeamsAttendees($id, $team_id),
            $expand,
            $query_params
        );
    }

    /**
     * post_series
     * POST /series/
     *        Creates a new repeating event series. The POST data must include information for at least one event date
     *        in the series.
     *        .. _get-series-by-id:
     *
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postSeries(array $data = []): array
    {
        return $this->client->post($this->endpoints->series(), $data);
    }

    /**
     * get_one_series
     * GET /series/:id/
     *        Returns a repeating event series parent object for the specified repeating event series.
     *        .. _post-series-by-id:
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOneSeries(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->oneSeries($id), $expand, $query_params);
    }

    /**
     * post_one_series
     * POST /series/:id/
     *        Updates a repeating event series parent object, and optionally also creates more event dates or updates
     *        or deletes existing event dates in the series. In order for a series date to be deleted or updated, there
     *        must be no pending or completed orders for that date.
     *        .. _publish-series-by-id:
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postOneSeries(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->oneSeries($id), $data);
    }

    /**
     * post_series_publish
     * POST /series/:id/publish/
     *        Publishes a repeating event series and all of its occurrences that are not already canceled or deleted.
     *        Once a date is cancelled it can still be uncancelled and can be viewed by the public. A deleted date
     *        cannot be undeleted and cannot by viewed by the public. In order for publish to be permitted, the event
     *        must have all necessary information, including a name and description, an organizer, at least one ticket,
     *        and valid payment options. This API endpoint will return argument errors for event fields that fail to
     *        validate the publish requirements. Returns a boolean indicating success or failure of the publish.
     *        field_error event.name MISSING Your event must have a name to be published. field_error event.start
     *        MISSING Your event must have a start date to be published. field_error event.end MISSING Your event must
     *        have an end date to be published. field_error event.start.timezone MISSING Your event start and end dates
     *        must have matching time zones to be published. field_error event.organizer MISSING Your event must have
     *        an organizer to be published. field_error event.currency MISSING Your event must have a currency to be published. field_error event.currency INVALID Your event must have a valid currency to be published. field_error event.tickets MISSING Your event must have at least one ticket to be published. field_error event.tickets.N.name MISSING All tickets must have names in order for your event to be published. The N will be the ticket class ID with the error. field_error event.tickets.N.quantity_total MISSING All non-donation tickets must have an available quantity value in order for your event to be published. The N will be the ticket class ID with the error. field_error event.tickets.N.cost MISSING All non-donation tickets must have a cost (which can be ``0.00`` for free tickets) in order for your event to be published. The N will be the ticket class ID with the error.
     *        .. _unpublish-series-by-id:
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postSeriesPublish(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->seriesPublish($id), $data);
    }

    /**
     * post_series_unpublish
     * POST /series/:id/unpublish/
     *        Unpublishes a repeating event series and all of its occurrences that are not already completed, canceled,
     *        or deleted. In order for a free series to be unpublished, it must not have any pending or completed
     *        orders for any dates, even past dates. In order for a paid series to be unpublished, it must not have any
     *        pending or completed orders for any dates, except that completed orders for past dates that have been
     *        completed and paid out do not prevent an unpublish. Returns a boolean indicating success or failure of
     *        the unpublish.
     *        .. _cancel-series-by-id:
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postSeriesUnpublish(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->seriesUnpublish($id), $data);
    }

    /**
     * post_series_cancel
     * POST /series/:id/cancel/
     *        Cancels a repeating event series and all of its occurrences that are not already canceled or deleted. In
     *        order for cancel to be permitted, there must be no pending or completed orders for any dates in the
     *        series. Returns a boolean indicating success or failure of the cancel.
     *        .. _delete-series-by-id:
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postSeriesCancel(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->seriesCancel($id), $data);
    }

    /**
     * delete_one_series
     * DELETE /series/:id/
     *        Deletes a repeating event series and all of its occurrences if the delete is permitted. In order for a
     *        delete to be permitted, there must be no pending or completed orders for any dates in the series. Returns
     *        a boolean indicating success or failure of the delete.
     *        .. _get-series-events:
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteOneSeries(int $id, array $data = []): array
    {
        return $this->client->delete($this->endpoints->oneSeries($id), $data);
    }

    /**
     * get_series_events
     * GET /series/:id/events/
     *        Returns all of the events that belong to this repeating event series.
     *        .. _post-series-dates:
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSeriesEvents(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->seriesEvents($id), $expand, $query_params);
    }

    /**
     * post_series_events
     * POST /series/:id/events/
     *        Creates more event dates or updates or deletes existing event dates in a repeating event series. In order
     *        for a series date to be deleted or updated, there must be no pending or completed orders for that date.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postSeriesEvents(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->seriesEvents($id), $data);
    }

    /**
     * get_formatss
     * GET /formats/
     *        Returns a list of :format:`format` as ``formats``.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFormatss(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->formatss(), $expand, $query_params);
    }

    /**
     * get_formats
     * GET /formats/:id/
     *        Gets a :format:`format` by ID as ``format``.*/
    /**
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFormats(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->formats($id), $expand, $query_params);
    }

    /**
     * get_media
     * GET /media/:id/
     *        Return an :format:`image` for a given id.
     *        .. _get-media-upload:
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMedia(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->media($id), $expand, $query_params);
    }

    /**
     * get_media_upload
     * GET /media/upload/
     *        See :ref:`media-uploads`.
     *        .. _post-media-upload:
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMediaUpload(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->mediaUpload(), $expand, $query_params);
    }

    /**
     * post_media_upload
     * POST /media/upload/
     *        See :ref:`media-uploads`.*/
    /**
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postMediaUpload(array $data = []): array
    {
        return $this->client->post($this->endpoints->mediaUpload(), $data);
    }

    /**
     * get_order
     * GET /orders/:id/
     *        Gets an :format:`order` by ID as the key ``order``.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOrder(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->order($id), $expand, $query_params);
    }

    /**
     * post_organizers
     * POST /organizers/
     *        Makes a new organizer. Returns an :format:`organizer` as ``organizer``.
     *        field_error organizer.name DUPLICATE
     *        You already have another organizer with this name.
     *        field_error organizer.short_name UNAVAILABLE
     *        There is already another organizer or event with this short name.
     *        field_error organizer.logo_id INVALID
     *        This is not a valid image.
     *        field_error organizer.facebook INVALID
     *        This is not a valid Facebook profile URL.
     *        field_error organizer.facebook NO_GROUP_PAGES
     *        The Facebook URL cannot be a group page.
     *
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postOrganizers(array $data = []): array
    {
        return $this->client->post($this->endpoints->organizers(), $data);
    }

    /**
     * get_organizer
     * GET /organizers/:id/
     *        Gets an :format:`organizer` by ID as ``organizer``.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOrganizer(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->organizer($id), $expand, $query_params);
    }

    /**
     * post_organizer
     * POST /organizers/:id/
     *        Updates an :format:`organizer` and returns it as as ``organizer``.
     *        field_error organizer.name DUPLICATE
     *        You already have another organizer with this name.
     *        field_error organizer.short_name UNAVAILABLE
     *        There is already another organizer or event with this short name.
     *        field_error organizer.logo_id INVALID
     *        This is not a valid image.
     *        field_error organizer.facebook INVALID
     *        This is not a valid Facebook profile URL.
     *        field_error organizer.facebook NO_GROUP_PAGES
     *        The Facebook URL cannot be a group page.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postOrganizer(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->organizer($id), $data);
    }

    /**
     * get_organizers_events
     * GET /organizers/:id/events/
     *        Gets events of the :format:`organizer`.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOrganizersEvents(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->organizersEvents($id), $expand, $query_params);
    }

    /**
     * @param int   $organizationId
     * @param array $expand
     * @param array $query_params
     * @return array
     */
    public function getOrganizationsEvents(int $organizationId, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->organizationsEvents($organizationId), $expand, $query_params);
    }

    /**
     * get_refund_request
     * GET /refund_requests/:id/
     *        Gets a :format:`refund-request` for the specified refund request.
     *        error NOT_AUTHORIZED
     *        Only the order's buyer can create a refund request
     *        error FIELD_UNKNOWN
     *        The refund request id provided is unknown
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRefundRequest(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->refundRequest($id), $expand, $query_params);
    }

    /**
     * post_refund_request
     * POST /refund_requests/:id/
     *        Update a :format:`refund-request` for a specific order. Each element in items is a :format:`refund-item`
     *        error NOT_AUTHORIZED
     *        Only the order's buyer can create a refund request
     *        error FIELD_UNKNOWN
     *        The refund request id provided is unknown
     *        error INVALID_REFUND_REQUEST_STATUS
     *        The refund request is not the correct status for the change
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postRefundRequest(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->refundRequest($id), $data);
    }

    /**
     * post_refund_requests
     * POST /refund_requests/
     *        Creates a :format:`refund-request` for a specific order. Each element in items is a :format:`refund-item`
     *        error NOT_AUTHORIZED
     *        Only the order's buyer can create a refund request
     *        error FIELD_UNKNOWN
     *        The order id provided is unknown
     *        error EVENT_DOES_NOT_ALLOW_REFUND_REQUESTS
     *        According to organizer definition, the event does not allow the creation of refund requests.
     *        error EXISTING_REFUND_REQUEST_FOR_ORDER
     *        The order already has a refund request
     *        error INVALID_ORDER_STATE
     *        The order status is not allowed to request a refund. It must
     * /**
     * be placed.
     */
    public function postRefundRequests(array $data = []): array
    {
        return $this->client->post($this->endpoints->refundRequests(), $data);
    }

    /**
     * get_reports_sales
     * GET /reports/sales/
     *        Returns a response of the aggregate sales data.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getReportsSales(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->reportsSales(), $expand, $query_params);
    }

    /**
     * get_reports_attendees
     * GET /reports/attendees/
     *        Returns a response of the aggregate attendees data.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getReportsAttendees(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->reportsAttendees(), $expand, $query_params);
    }

    /**
     * get_system_timezones
     * GET /system/timezones/
     *        Returns a :ref:`paginated <pagination>` response with a key of ``timezones``,
     *        containing a list of :format:`timezones <timezone>`.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSystemTimezones(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->systemTimezones(), $expand, $query_params);
    }

    /**
     * get_system_regions
     * GET /system/regions/
     *        Returns a single page response with a key of ``regions``,
     *        containing a list of :format:`regions`.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSystemRegions(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->systemRegions(), $expand, $query_params);
    }

    /**
     * get_system_countries
     * GET /system/countries/
     *        Returns a single page response with a key of ``countries``,
     *        containing a list of :format:`countries`.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSystemCountries(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->systemCountries(), $expand, $query_params);
    }

    /**
     * post_tracking_beacons
     * POST /tracking_beacons/
     *        Makes a new tracking beacon. Returns an :format:`tracking_beacon` as ``tracking_beacon``. Either
     *        ``event_id`` or ``user_id`` is required for each tracking beacon. If the ``event_id`` is provided, the
     *        tracking pixel will fire only for that event. If the ``user_id`` is provided, the tracking pixel will
     *        fire for all events organized by that user. field_error tracking_beacon.event_id INVALID This is not a
     *        valid event. field_error tracking_beacon.user_id INVALID This is not a valid user.
     *
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postTrackingBeacons(array $data = []): array
    {
        return $this->client->post($this->endpoints->trackingBeacons(), $data);
    }

    /**
     * get_tracking_beacon
     * GET /tracking_beacons/:tracking_beacons_id/
     *        Returns the :format:`tracking_beacon` with the specified :tracking_beacons_id.
     *
     * @param       $tracking_beacons_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTrackingBeacon(
        $tracking_beacons_id,
        array $expand = [],
        array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->trackingBeacon($tracking_beacons_id),
            $expand,
            $query_params
        );
    }

    /**
     * post_tracking_beacon
     * POST /tracking_beacons/:tracking_beacons_id/
     *        Updates the :format:`tracking_beacons` with the specified :tracking_beacons_id. Though ``event_id`` and
     *        ``user_id`` are not individually required, it is a requirement to have a tracking beacon where either one
     *        must exist. Returns an :format:`tracking_beacon` as ``tracking_beacon``.
     *
     * @param       $tracking_beacons_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postTrackingBeacon($tracking_beacons_id, array $data = []): array
    {
        return $this->client->post($this->endpoints->trackingBeacon($tracking_beacons_id), $data);
    }

    /**
     * delete_tracking_beacon
     * DELETE /tracking_beacons/:tracking_beacons_id/
     *        Delete the :format:`tracking_beacons` with the specified :tracking_beacons_id.
     *
     * @param       $tracking_beacons_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteTrackingBeacon($tracking_beacons_id, array $data = []): array
    {
        return $this->client->delete($this->endpoints->trackingBeacon($tracking_beacons_id), $data);
    }

    /**
     * get_event_tracking_beacons
     * GET /events/:event_id/tracking_beacons/
     *        Returns the list of :format:`tracking_beacon` for the event :event_id
     *
     * @param       $event_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventTrackingBeacons($event_id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->eventTrackingBeacons($event_id),
            $expand,
            $query_params
        );
    }

    /**
     * get_user_tracking_beacons
     * GET /users/:user_id/tracking_beacons/
     *        Returns the list of :format:`tracking_beacon` for the user :user_id
     *
     * @param       $user_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserTrackingBeacons($user_id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->userTrackingBeacons($user_id),
            $expand,
            $query_params
        );
    }

    /**
     * get_user
     * GET /users/:id/
     *        Returns a :format:`user` for the specified user as ``user``. If you want to get details about the
     *        currently authenticated user, use ``/users/me/``.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUser(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->user($id), $expand, $query_params);
    }

    /**
     * get_user_orders
     * GET /users/:id/orders/
     *        Returns a :ref:`paginated <pagination>` response of :format:`orders <order>`, under the key ``orders``,
     *        of all orders the user has placed (i.e. where the user was the person buying the tickets).
     *        :param int id: The id assigned to a user.
     *        :param datetime changed_since: (optional) Only return attendees changed on or after the time given.
     *        .. note:: A datetime represented as a string in ISO8601 combined date and time format, always in UTC.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserOrders(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->userOrders($id), $expand, $query_params);
    }

    /**
     * get_user_organizers
     * GET /users/:id/organizers/
     *        Returns a :ref:`paginated <pagination>` response of :format:`organizer` objects that are owned by the
     *        user.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserOrganizers(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->userOrganizers($id), $expand, $query_params);
    }

    /**
     * get_user_owned_events
     * GET /users/:id/owned_events/
     *        Returns a :ref:`paginated <pagination>` response of :format:`events <event>`, under
     *        the key ``events``, of all events the user owns (i.e. events they are organising)
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserOwnedEvents(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->userOwnedEvents($id), $expand, $query_params);
    }

    /**
     * get_user_events
     * GET /users/:id/events/
     *        Returns a :ref:`paginated <pagination>` response of :format:`events <event>`, under the key ``events``,
     *        of all events the user has access to
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserEvents(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->userEvents($id), $expand, $query_params);
    }

    /**
     * get_user_venues
     * GET /users/:id/venues/
     *        Returns a paginated response of :format:`venue` objects that are owned by the user.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserVenues(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->userVenues($id), $expand, $query_params);
    }

    /**
     * get_user_owned_event_attendees
     * GET /users/:id/owned_event_attendees/
     *        Returns a :ref:`paginated <pagination>` response of :format:`attendees <attendee>`,
     *        under the key ``attendees``, of attendees visiting any of the events the user owns
     *        (events that would be returned from ``/users/:id/owned_events/``)
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserOwnedEventAttendees(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->userOwnedEventAttendees($id),
            $expand,
            $query_params
        );
    }

    /**
     * get_user_owned_event_orders
     * GET /users/:id/owned_event_orders/
     *        Returns a :ref:`paginated <pagination>` response of :format:`orders <order>`,
     *        under the key ``orders``, of orders placed against any of the events the user owns
     *        (events that would be returned from ``/users/:id/owned_events/``)
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserOwnedEventOrders(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->userOwnedEventOrders($id),
            $expand,
            $query_params
        );
    }

    /**
     * get_user_contact_lists
     * GET /users/:id/contact_lists/
     *        Returns a list of :format:`contact_list` that the user owns as the key
     *        ``contact_lists``.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserContactLists(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get(
            $this->endpoints->userContactLists($id),
            $expand,
            $query_params
        );
    }

    /**
     * post_user_contact_lists
     * POST /users/:id/contact_lists/
     *        Makes a new :format:`contact_list` for the user and returns it as
     *        ``contact_list``.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postUserContactLists(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->userContactLists($id), $data);
    }

    /**
     * get_user_contact_list
     * GET /users/:id/contact_lists/:contact_list_id/
     *        Gets a user's :format:`contact_list` by ID as ``contact_list``.
     *
     * @param int   $id
     * @param       $contact_list_id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserContactList(int $id, int $contact_list_id, array $expand = [], array $query_params = []):
    array {
        return $this->client->get(
            $this->endpoints->userContactList($id, $contact_list_id),
            $expand,
            $query_params
        );
    }

    /**
     * post_user_contact_list
     * POST /users/:id/contact_lists/:contact_list_id/
     *        Updates the :format:`contact_list` and returns it as ``contact_list``.
     *
     * @param int   $id
     * @param       $contact_list_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postUserContactList(int $id, int $contact_list_id, array $data = []): array
    {
        return $this->client->post($this->endpoints->userContactList($id, $contact_list_id), $data);
    }

    /**
     * delete_user_contact_list
     * DELETE /users/:id/contact_lists/:contact_list_id/
     *        Deletes the contact list. Returns ``{"deleted": true}``.
     *
     * @param int   $id
     * @param       $contact_list_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteUserContactList(int $id, int $contact_list_id, array $data = []): array
    {
        return $this->client->delete($this->endpoints->userContactList($id, $contact_list_id), $data);
    }

    /**
     * get_user_contact_lists_contacts
     * GET /users/:id/contact_lists/:contact_list_id/contacts/
     *        Returns the :format:`contacts <contact>` on the contact list
     *        as ``contacts``.
     */
    /**
     * @param int   $id
     * @param int   $contact_list_id
     * @param array $expand
     * @param array $query_params
     * @return mixed
     */
    public function getUserContactListsContacts(
        int $id,
        int $contact_list_id,
        array $expand = [],
        array $query_params = [])
    {
        return $this->client->get(
            $this->endpoints->userContactListsContacts($id, $contact_list_id),
            $expand,
            $query_params
        );
    }

    /**
     * post_user_contact_lists_contacts
     * POST /users/:id/contact_lists/:contact_list_id/contacts/
     *        Adds a new contact to the contact list. Returns ``{"created": true}``.
     *        There is no way to update entries in the list; just delete the old one
     *        and add the updated version.
     *
     * @param int   $id
     * @param       $contact_list_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postUserContactListsContacts(int $id, int $contact_list_id, array $data = []): array
    {
        return $this->client->post(
            $this->endpoints->userContactListsContacts($id, $contact_list_id),
            $data
        );
    }

    /**
     * delete_user_contact_lists_contacts
     * DELETE /users/:id/contact_lists/:contact_list_id/contacts/
     *        Deletes the specified contact from the contact list.
     *        Returns ``{"deleted": true}``.
     * =======
     *
     * @param int   $id
     * @param       $contact_list_id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteUserContactListsContacts(int $id, int $contact_list_id, array $data = []): array
    {
        return $this->client->delete(
            $this->endpoints->userContactListsContacts($id, $contact_list_id),
            $data
        );
    }

    /**
     * get_user_bookmarks
     * GET /users/:id/bookmarks/
     *        Gets all the user's saved events.
     *        In order to update the saved events list, the user must unsave or save each event.
     *        A user is authorized to only see his/her saved events.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserBookmarks(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->userBookmarks($id), $expand, $query_params);
    }

    /**
     * post_user_bookmarks_save
     * POST /users/:id/bookmarks/save/
     *        Adds a new bookmark for the user. Returns ``{"created": true}``.
     *        A user is only authorized to save his/her own events.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postUserBookmarksSave(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->userBookmarksSave($id), $data);
    }

    /**
     * post_user_bookmarks_unsave
     * POST /users/:id/bookmarks/unsave/
     *        Removes the specified bookmark from the event for the user. Returns ``{"deleted": true}``.
     *        A user is only authorized to unsave his/her own events.
     *        error NOT_AUTHORIZED
     *        You are not authorized to unsave an event for this user.
     *        error ARGUMENTS_ERROR
     *        There are errors with your arguments.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postUserBookmarksUnsave(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->userBookmarksUnsave($id), $data);
    }

    /**
     * get_venue
     * GET /venues/:id/
     *        Returns a :format:`venue` object.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVenue(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->venue($id), $expand, $query_params);
    }

    /**
     * post_venue
     * POST /venues/:id/
     *        Updates a :format:`venue` and returns it as an object.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postVenue(int $id, array $data = []): array
    {
        return $this->client->post($this->endpoints->venue($id), $data);
    }

    /**
     * post_venues
     * POST /venues/
     *        Creates a new :format:`venue` with associated :format:`address`.
     *        ..start-internal
     *
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postVenues(array $data = []): array
    {
        return $this->client->post($this->endpoints->venues(), $data);
    }

    /**
     * get_venues_search
     * GET /venues/search/
     *        Search for venues. Returns a list of venue objects.
     *        ..end-internal
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVenuesSearch(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->venuesSearch(), $expand, $query_params);
    }

    /**
     * get_venues_events
     * GET /venues/:id/events/
     *        Returns events of a given :format:`venue`.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVenuesEvents(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->venuesEvents($id), $expand, $query_params);
    }

    /**
     * get_webhook
     * GET /webhooks/:id/
     *        Returns a :format:`webhook` for the specified webhook as ``webhook``.
     *
     * @param int   $id
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWebhook(int $id, array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->webhook($id), $expand, $query_params);
    }

    /**
     * delete_webhook
     * DELETE /webhooks/:id/
     *        Deletes the specified :format:`webhook` object.
     *
     * @param int   $id
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteWebhook(int $id, array $data = []): array
    {
        return $this->client->delete($this->endpoints->webhook($id), $data);
    }

    /**
     * get_webhooks
     * GET /webhooks/
     *        Returns the list of :format:`webhook` objects that belong to the authenticated user.
     *
     * @param array $expand
     * @param array $query_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWebhooks(array $expand = [], array $query_params = []): array
    {
        return $this->client->get($this->endpoints->webhooks(), $expand, $query_params);
    }

    /**
     * post_webhooks
     * POST /webhooks/
     *        Creates a :format:`webhook` for the authenticated user.
     *        The ``actions`` parameter accepts a comma-separated value that can include any or all of the following:
     *        * ``attendee.checked_in`` - Triggered when an attendee's barcode is scanned in.
     *        * ``attendee.checked_out`` - Triggered when an attendee's barcode is scanned out.
     *        * ``attendee.updated`` - Triggered when attendee data is updated.
     *        * ``event.created`` - Triggered when an event is initially created.
     *        * ``event.published`` - Triggered when an event is published and made live.
     *        * ``event.updated`` - Triggered when event data is updated.
     *        * ``event.unpublished`` - Triggered when an event is unpublished.
     *        * ``order.placed`` - Triggers when an order is placed for an event. Generated Webhook's API endpoint is
     *        to the Order endpoint.
     *        * ``order.refunded`` - Triggers when an order is refunded for an event.
     *        * ``order.updated`` - Triggers when order data is updated for an event.
     *        * ``organizer.updated`` - Triggers when organizer data is updated.
     *        * ``ticket_class.created`` - Triggers when a ticket class is created.
     *        * ``ticket_class.deleted`` - Triggers when a ticket class is deleted.
     *        * ``ticket_class.updated`` - Triggers when a ticket class is updated.
     *        * ``venue.updated`` - Triggers when venue data is updated
     *
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postWebhooks(array $data = []): array
    {
        return $this->client->post($this->endpoints->webhooks(), $data);
    }
}
