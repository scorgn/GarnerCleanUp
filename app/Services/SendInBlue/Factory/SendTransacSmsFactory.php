<?php declare(strict_types=1);

namespace App\Services\SendInBlue\Factory;

use SendinBlue\Client\Model\SendTransacSms;

/**
 * Class SendTransacSmsFactory
 * @package App\Services\SendInBlue\Factory
 */
class SendTransacSmsFactory
{
    /**
     * @param string $senderName
     * @param string $recipientNumber
     * @param string $content
     * @return SendTransacSms
     */
    public function create(
        string $senderName,
        string $recipientNumber,
        string $content,
    ): SendTransacSms {
        return new SendTransacSms([
            'sender' => $senderName,
            'recipient' => $recipientNumber,
            'content' => $content
        ]);
    }
}
