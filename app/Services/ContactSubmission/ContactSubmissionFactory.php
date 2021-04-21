<?php declare(strict_types=1);

namespace App\Services\ContactSubmission;

use JetBrains\PhpStorm\Pure;

/**
 * Class ContactSubmissionFactory
 */
class ContactSubmissionFactory
{
    /**
     * @param string $name
     * @param ?string $email
     * @param ?string $phone
     * @param string $message
     * @param bool   $subscribe
     * @return Submission
     */
    #[Pure] public function create(
        string $name,
        ?string $email,
        ?string $phone,
        string $message,
        bool $subscribe,
    ): Submission {
        return new Submission(
            name: $name,
            email: $email,
            phone: $phone,
            message: $message,
            subscription: $subscribe,
        );
    }
}
