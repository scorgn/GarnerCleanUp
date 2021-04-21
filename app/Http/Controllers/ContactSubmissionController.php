<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactSubmissionRequest;
use App\Services\ContactSubmission\ContactSubmissionFactory;
use App\Services\ContactSubmissionServiceInterface;
use App\Services\Mailchimp\MailchimpSubscribeService;
use App\Services\SubscribeServiceInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class ContactSubmissionController
 * @package App\Http\Controllers
 */
class ContactSubmissionController extends Controller
{
    /**
     * ContactSubmissionController constructor.
     * @param SubscribeServiceInterface         $subscribeService
     * @param ContactSubmissionServiceInterface $contactSubmissionService
     * @param ContactSubmissionFactory          $contactSubmissionFactory
     */
    public function __construct(
        private SubscribeServiceInterface $subscribeService,
        private ContactSubmissionServiceInterface $contactSubmissionService,
        private ContactSubmissionFactory $contactSubmissionFactory,
    ) { }

    /**
     * @param ContactSubmissionRequest $request
     * @return JsonResponse
     */
    public function __invoke(ContactSubmissionRequest $request): JsonResponse
    {
        $shouldSubscribe = $request->has('subscribe')
            ? (bool) $request->get('subscribe')
            : false;

        $email = $request->get('email');

        $submission = $this->contactSubmissionFactory->create(
            name: $request->get('name'),
            email: $email,
            phone: $request->get('phone'),
            message: $request->get('message'),
            subscribe: $shouldSubscribe
        );

        try {
            $this->contactSubmissionService->submit($submission);
        } catch (\Throwable $e) {
            \Log::error("There was an error with the contact submission", [
                'submission' => $submission->toArray(),
                'error' => [
                    'message' => $e->getMessage(),
                    'class' => get_class($e),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'trace' => $e->getTraceAsString(),
                ],
            ]);

            return new JsonResponse([
                'error' => true,
                'message' => 'There was an error with your request. Please try again later.'
            ]);
        }

        try {
            if ($shouldSubscribe) {
                $this->subscribeService->subscribe($email);
            }
        } catch (\Throwable $e) {
            \Log::critical("User tried signing up to list with contact form but error occurred.", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => get_class($e),
            ]);
        }

        return new JsonResponse(['error' => false, 'message' => "Submission successful"]);
    }
}
