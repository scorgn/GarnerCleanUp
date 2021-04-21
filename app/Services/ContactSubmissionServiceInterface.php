<?php declare(strict_types=1);

namespace App\Services;

use App\Services\ContactSubmission\Submission;

/**
 * interface ContactSubmissionServiceInterface
 * @package App\Services
 */
interface ContactSubmissionServiceInterface
{
    /***
     * @param Submission $submission
     * @return bool
     */
    public function submit(Submission $submission): bool;
}
