<?php declare(strict_types=1);

namespace App\Services\ContactSubmission;

use App\Events\ContactSubmissionEvent;
use App\Services\ContactSubmissionServiceInterface;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class EventBasedContactSubmissionService
 * @package App\Services\ContactSubmission
 */
class EventBasedContactSubmissionService implements ContactSubmissionServiceInterface
{
    /**
     * EventBasedContactSubmissionService constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(private Dispatcher $dispatcher)
    { }

    /**
     * @param Submission $submission
     * @return bool
     */
    public function submit(Submission $submission): bool
    {
        $this->dispatcher->dispatch(new ContactSubmissionEvent($submission));

        return true;
    }
}
