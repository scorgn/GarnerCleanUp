<?php declare(strict_types=1);

namespace App\Events;

use App\Services\ContactSubmission\Submission;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ContactSubmissionEvent
 * @package App\Events
 */
class ContactSubmissionEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Submission $submission
     */
    public function __construct(private Submission $submission)
    { }

    /**
     * @return Submission
     */
    public function getSubmission(): Submission
    {
        return $this->submission;
    }
}
