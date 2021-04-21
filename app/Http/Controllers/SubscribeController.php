<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Exceptions\MailchimpException;
use App\Http\Requests\SubscribeRequest;
use App\Services\SubscribeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class SubscribeController
 * @package App\Http\Controllers
 */
class SubscribeController
{
    /**
     * SubscribeController constructor.
     * @param SubscribeServiceInterface $subscribeService
     */
    public function __construct(
        private SubscribeServiceInterface $subscribeService
    ) { }

    /**
     * @param SubscribeRequest $request
     * @return JsonResponse
     */
    public function __invoke(SubscribeRequest $request): JsonResponse
    {
        try {
            $email = $request->input('email');
            $this->subscribeService->subscribe($email);

            Log::debug("User subscribed with email.", [
                'email' => $email,
            ]);

            return new JsonResponse([
                'error' => false,
                'message' => "Thank you for subscribing."
            ]);
        } catch (MailchimpException $e) {
            Log::error("Mailchimp error subscribing with email.", [
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'trace' => $e->getTraceAsString(),
            ]);

            return new JsonResponse([
                'error' => true,
                'message' => $e->getFriendlyMessage(),
            ], status: 500);
        } catch (Exception $e) {
            Log::error("General exception when subscribing with email.", [
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return new JsonResponse([
                'error' => true,
                'message' => "Unexpected error. Please try again later.",
            ], status: 500);
        }
    }
}
