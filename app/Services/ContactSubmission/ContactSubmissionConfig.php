<?php declare(strict_types=1);

namespace App\Services\ContactSubmission;

/**
 * Class ContactSubmissionConfig
 * @package App\Services\ContactSubmission
 */
class ContactSubmissionConfig
{
    /**
     * ContactSubmissionConfig constructor.
     * @param string $toEmail
     * @param string $toName
     * @param string $fromEmail
     * @param string $fromName
     * @param string $toPhoneNumber
     */
    public function __construct(
        private string $toEmail,
        private string $toName,
        private string $fromEmail,
        private string $fromName,
        private string $toPhoneNumber,
    ) { }

    /**
     * @return string
     */
    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    /**
     * @return string
     */
    public function getToName(): string
    {
        return $this->toName;
    }

    /**
     * @return string
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @return string
     */
    public function getToPhoneNumber(): string
    {
        return $this->toPhoneNumber;
    }
}
