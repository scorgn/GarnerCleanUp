<?php declare(strict_types=1);

namespace App\Services\Mailchimp;

use App\Exceptions\MailchimpException;
use App\Services\SubscribeServiceInterface;
use DrewM\MailChimp\MailChimp;
use Mockery\Exception;

/**
 * Class MailchimpSubscribeService
 */
class MailchimpSubscribeService implements SubscribeServiceInterface
{
    /**
     * Subscribed Status
     */
    private const SUBSCRIBED_STATUS = 'subscribed';

    /**
     * MailchimpSubscribeService constructor.
     * @param MailChimp       $mailChimp
     * @param MailchimpConfig $config
     */
    public function __construct(
        private Mailchimp $mailChimp,
        private MailchimpConfig $config
    ) {
    }

    /**
     * @param string $email
     * @return bool
     * @throws MailchimpException
     */
    public function subscribe(string $email): bool
    {
        $this->mailChimp->post(
            sprintf('/lists/%s/members', $this->config->getAudienceId()),
            [
                'email_address' => $email,
                'status' => self::SUBSCRIBED_STATUS
            ]
        );

        if ($this->mailChimp->success()) {
            return true;
        }

        $friendlyErrorMessage = $this->friendlyErrorMessage($this->mailChimp->getLastError());

        throw new MailchimpException($friendlyErrorMessage, $this->mailChimp->getLastError());
    }

    /**
     * @param string $message
     * @return string
     */
    public function friendlyErrorMessage(string $message): string
    {
        if (str_contains($message, 'already a list member')) {
            return "You are already subscribed to our events with that email address.";
        }

        return "Unexpected error. Please try again later.";
    }
}
