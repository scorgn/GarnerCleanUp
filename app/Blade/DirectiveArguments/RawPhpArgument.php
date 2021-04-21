<?php declare(strict_types=1);

namespace App\Blade\DirectiveArguments;

use App\Blade\DirectiveArgument;
use JetBrains\PhpStorm\Pure;

/**
 * Class RawPhpArgument
 */
class RawPhpArgument extends DirectiveArgument
{
    /**
     * @return string
     */
    #[Pure] public function asCode(): string
    {
        return sprintf('(%s)', $this->value);
    }

    /**
     * @return bool
     */
    #[Pure] public function isRawPhp(): bool
    {
        return true;
    }
}
