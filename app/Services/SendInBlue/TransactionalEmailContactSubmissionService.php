<?php declare(strict_types=1);

namespace App\Services\SendInBlue;

use App\Services\ContactSubmission\ContactSubmissionConfig;
use App\Services\ContactSubmission\Submission;
use App\Services\ContactSubmissionServiceInterface;
use App\Services\SendInBlue\Factory\SendSmtpEmailFactory;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\ApiException;

/**
 * Class SendInBlueContactSubmissionService
 */
class TransactionalEmailContactSubmissionService implements ContactSubmissionServiceInterface
{
    /**
     * Email subject format
     */
    private const EMAIL_SUBJECT = 'You received a new contact submission from %s';

    /**
     * TransactionalEmailContactSubmissionService constructor.
     * @param TransactionalEmailsApi  $transactionalEmailsApi
     * @param SendSmtpEmailFactory    $emailFactory
     * @param ContactSubmissionConfig $config
     */
    public function __construct(
        private TransactionalEmailsApi $transactionalEmailsApi,
        private SendSmtpEmailFactory $emailFactory,
        private ContactSubmissionConfig $config,
    ) { }

    /**
     * @param Submission $submission
     * @return bool
     * @throws ApiException
     * @throws \JsonException|\Throwable
     */
    public function submit(Submission $submission): bool
    {
        try {
            $email = $this->emailFactory->create(
                $this->config->getFromEmail(),
                $this->config->getFromName(),
                $this->config->getToEmail(),
                $this->config->getToName(),
                sprintf(self::EMAIL_SUBJECT, $submission->getName()),
                $submission->toJson(JSON_PRETTY_PRINT)
            );

            $this->transactionalEmailsApi->sendTransacEmail($email);

            return true;
        } catch (\Throwable  $e) {
            \Log::debug("Error with TransactionalEmailContactSubmissionService: ", [
                'error' => [
                    'message' => $e->getMessage(),
                    'class' => get_class($e),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'trace' => $e->getTraceAsString(),
                ],
                'submission' => $submission->toArray()
            ]);

            throw $e;
        }
    }
}
