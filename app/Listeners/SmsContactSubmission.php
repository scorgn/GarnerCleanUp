<?php declare(strict_types=1);

namespace App\Listeners;

use App\Events\ContactSubmissionEvent;
use App\Services\SendInBlue\TransactionalSmsContactSubmissionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class EmailContactSubmission
 * @package App\Listeners
 */
class SmsContactSubmission implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of times this listener can be attempted
     *
     * @var int
     */
    public int $tries = 1;

    /**
     * SmsContactSubmission constructor.
     * @param TransactionalSmsContactSubmissionService $service
     */
    public function __construct(
        private TransactionalSmsContactSubmissionService $service
    ) { }

    /**
     * @param ContactSubmissionEvent $event
     */
    public function handle(ContactSubmissionEvent $event): void
    {
        try {
            $this->service->submit($event->getSubmission());
        } catch (\Throwable  $e) {
            \Log::debug("Error with SmsContactSubmission: ", [
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
