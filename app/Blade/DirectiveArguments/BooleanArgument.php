<?php declare(strict_types=1);

namespace App\Blade\DirectiveArguments;

use App\Blade\DirectiveArgument;
use JetBrains\PhpStorm\Pure;

/**
 * Class BooleanArgument
 */
class BooleanArgument extends DirectiveArgument
{
    /**
     * @return bool
     */
    public function isTrue(): bool
    {
        return $this->value === 'true';
    }

    /**
     * @return bool
     */
    public function isFalse(): bool
    {
        return $this->value === 'false';
    }

    /**
     * @return bool
     */
    #[Pure] public function isBoolean(): bool
    {
        return true;
    }
}
