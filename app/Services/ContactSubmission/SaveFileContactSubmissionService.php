<?php declare(strict_types=1);

namespace App\Services\ContactSubmission;

use App\Services\ContactSubmissionServiceInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use JetBrains\PhpStorm\Pure;
use JsonException;

/**
 * Class SaveFileContactSubmissionService
 * @package App\Services\ContactSubmission
 */
class SaveFileContactSubmissionService implements ContactSubmissionServiceInterface
{
    /**
     * SaveFileContactSubmissionService constructor.
     * @param Filesystem              $filesystem
     * @param ContactSubmissionConfig $config
     */
    public function __construct(
        private Filesystem $filesystem,
        private ContactSubmissionConfig $config,
    ) { }

    /**
     * @param Submission $submission
     * @return bool
     * @throws JsonException
     */
    public function submit(Submission $submission): bool
    {
        try {
            return $this->filesystem->put(
                $this->generateFileName(),
                $submission->toJson(JSON_PRETTY_PRINT),
            );
        } catch (\Throwable $e) {
            \Log::error("Error saving contact submission file", [
                'error' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'class' => get_class($e),
                    'trace' => $e->getTraceAsString(),
                ],
                'submission' => $submission->toArray(),
            ]);
        }
    }

    /**
     * @return string
     */
    #[Pure] private function generateFileName(): string
    {
        return sprintf(
            'submissions/%s.log',
            date('Y-m-d_H-i-s'),
        );
    }
}
