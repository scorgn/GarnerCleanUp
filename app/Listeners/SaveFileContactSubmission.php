<?php declare(strict_types=1);

namespace App\Listeners;

use App\Events\ContactSubmissionEvent;
use App\Services\ContactSubmission\SaveFileContactSubmissionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class SaveFileContactSubmission
 * @package App\Listeners
 */
class SaveFileContactSubmission implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * EmailContactSubmission constructor.
     * @param SaveFileContactSubmissionService $service
     */
    public function __construct(
        private SaveFileContactSubmissionService $service,
    ) { }

    /**
     * @param ContactSubmissionEvent $event
     */
    public function handle(ContactSubmissionEvent $event): void
    {
        try {
            $this->service->submit($event->getSubmission());
        } catch (\Throwable  $e) {
            \Log::debug("Error saving contact submission file.", [
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
