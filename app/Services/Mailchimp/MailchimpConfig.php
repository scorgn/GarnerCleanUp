<?php declare(strict_types=1);

namespace App\Services\Mailchimp;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

/**
 * Class MailchimpConfig
 */
class MailchimpConfig
{
    /**
     * MailchimpConfig constructor.
     * @param string $audienceId
     */
    #[Immutable] public function __construct(private string $audienceId)
    { }

    /**
     * @return string
     */
    #[Pure] public function getAudienceId(): string
    {
       return $this->audienceId;
    }
}
