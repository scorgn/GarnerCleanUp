<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class MailchimpException
 * @package App\Exceptions
 */
class MailchimpException extends Exception
{
    /**
     * MailchimpException constructor.
     * @param string         $friendlyMessage
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        private $friendlyMessage = 'Unexpected error. Please try again later.',
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getFriendlyMessage(): string
    {
        return $this->friendlyMessage;
    }
}
