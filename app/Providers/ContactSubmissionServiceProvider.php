<?php declare(strict_types=1);

namespace App\Providers;

use App\Services\ContactSubmission\ContactSubmissionConfig;
use App\Services\ContactSubmission\EventBasedContactSubmissionService;
use App\Services\ContactSubmissionServiceInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class ContactSubmissionServiceProvider
 * @package App\Providers
 */
class ContactSubmissionServiceProvider extends ServiceProvider
{
    /**
     * Register contact submission services
     */
    public function register(): void
    {
        $this->app->bind(
            ContactSubmissionServiceInterface::class,
            EventBasedContactSubmissionService::class
        );

        $this->app->singleton(
            ContactSubmissionConfig::class,
            fn ($app) => new ContactSubmissionConfig(
                config('contactsubmission.to-email'),
                config('contactsubmission.to-name'),
                config('contactsubmission.from-email'),
                config('contactsubmission.from-name'),
                config('contactsubmission.to-phone-number')
            )
        );
    }
}
