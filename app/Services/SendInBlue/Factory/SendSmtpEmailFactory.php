<?php declare(strict_types=1);

namespace App\Services\SendInBlue\Factory;

use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\SendSmtpEmailSender;
use SendinBlue\Client\Model\SendSmtpEmailTo;

/**
 * Class SendSmtpEmailFactory
 */
class SendSmtpEmailFactory
{
    /**
     * @param string      $fromEmail
     * @param string      $fromName
     * @param string      $toEmail
     * @param string      $toName
     * @param string      $subject
     * @param string      $textContent
     * @param string|null $htmlContent
     * @return SendSmtpEmail
     */
    public function create(
        string $fromEmail,
        string $fromName,
        string $toEmail,
        string $toName,
        string $subject,
        string $textContent,
        string $htmlContent = null,
    ): SendSmtpEmail {
        $sender = new SendSmtpEmailSender([
            'name' => $fromName,
            'email' => $fromEmail,
        ]);
        $recipient = new SendSmtpEmailTo([
            'name' => $toName,
            'email' => $toEmail,
        ]);

        return new SendSmtpEmail([
            'sender' => $sender,
            'to' => [$recipient],
            'htmlContent' => $htmlContent ?? $textContent,
            'textContent' => $textContent,
            'subject' => $subject,
        ]);
    }
}
