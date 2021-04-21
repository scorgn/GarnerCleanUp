<?php declare(strict_types=1);

namespace App\Listeners;

use App\Events\ContactSubmissionEvent;
use App\Services\SendInBlue\TransactionalEmailContactSubmissionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class EmailContactSubmission
 * @package App\Listeners
 */
class EmailContactSubmission implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * EmailContactSubmission constructor.
     * @param TransactionalEmailContactSubmissionService $service
     */
    public function __construct(
        private TransactionalEmailContactSubmissionService $service
    ) { }

    /**
     * @param ContactSubmissionEvent $event
     */
    public function handle(ContactSubmissionEvent $event): void
    {
        try {
            $this->service->submit($event->getSubmission());
        } catch (\Throwable  $e) {
            \Log::debug("Error in EmailContactSubmission handler.", [
                'error' => [
                    'message' => $e->getMessage(),
                    'class' => get_class($e),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'trace' => $e->getTraceAsString(),
                ],
                'submission' => $event->getSubmission()->toArray(),
            ]);

            $this->fail($e);
        }
    }
}
