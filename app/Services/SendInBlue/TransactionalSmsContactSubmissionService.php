<?php declare(strict_types=1);

namespace App\Services\SendInBlue;

use App\Services\ContactSubmission\ContactSubmissionConfig;
use App\Services\ContactSubmission\Submission;
use App\Services\ContactSubmissionServiceInterface;
use App\Services\SendInBlue\Factory\SendTransacSmsFactory;
use SendinBlue\Client\Api\TransactionalSMSApi;

/**
 * Class TransactionalSmsContactSubmissionService
 */
class TransactionalSmsContactSubmissionService implements ContactSubmissionServiceInterface
{
    /**
     * SMS Content Format
     */
    private const SMS_CONTENT_FORMAT = 'You have a new contact submission from %s. Message: %s';

    /**
     * TransactionalSmsContactSubmissionService constructor.
     * @param TransactionalSMSApi     $transactionalSmsApi
     * @param SendTransacSmsFactory   $smsFactory
     * @param ContactSubmissionConfig $config
     */
    public function __construct(
        private TransactionalSMSApi $transactionalSmsApi,
        private SendTransacSmsFactory $smsFactory,
        private ContactSubmissionConfig $config,
    ) { }

    /**
     * @param Submission $submission
     * @return bool
     * @throws \SendinBlue\Client\ApiException
     */
    public function submit(Submission $submission): bool
    {
        try {
            $sms = $this->smsFactory->create(
                $this->config->getFromName(),
                $this->config->getToPhoneNumber(),
                sprintf(
                    self::SMS_CONTENT_FORMAT,
                    $submission->getName(),
                    $submission->getMessage()
                ),
            );

            $this->transactionalSmsApi->sendTransacSms($sms);

            return true;
        } catch (\Throwable  $e) {
            \Log::debug("Error with TransactionalSmsContactSubmissionService: ", [
                'error' => [
                    'message' => $e->getMessage(),
                    'class' => get_class($e),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'trace' => $e->getTraceAsString(),
                ],
                'submission' => $submission->toArray(),
            ]);

            throw $e;
        }
    }
}
