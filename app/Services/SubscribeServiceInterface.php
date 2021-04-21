<?php declare(strict_types=1);

namespace App\Services;

/**
 * Interface SubscribeServiceInterface
 * @package App\Services
 */
interface SubscribeServiceInterface
{
    /**
     * @param string $email
     * @return bool
     */
    public function subscribe(string $email): bool;
}
