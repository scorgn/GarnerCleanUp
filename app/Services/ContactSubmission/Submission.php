<?php declare(strict_types=1);

namespace App\Services\ContactSubmission;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;

/**
 * Class Submission
 */
class Submission implements Arrayable, Jsonable
{
    /**
     * Submission constructor.
     * @param string $name
     * @param ?string $email
     * @param ?string $phone
     * @param string $message
     * @param bool   $subscription
     */
    public function __construct(
        private string $name,
        private ?string $email,
        private ?string $phone,
        private string $message,
        private bool $subscription
    ) { }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isSubscription(): bool
    {
        return $this->subscription;
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'name' => "string",
        'email' => "string|null",
        'phone' => "string|null",
        'message' => "string",
        'subscription' => "bool"
    ])] public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'subscription' => $this->subscription,
        ];
    }

    /**
     * @param int $options
     * @return bool|string
     * @throws JsonException
     */
    public function toJson($options = 0): bool|string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | $options);
    }
}
