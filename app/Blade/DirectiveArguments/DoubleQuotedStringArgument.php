<?php declare(strict_types=1);

namespace App\Blade\DirectiveArguments;

use App\Blade\DirectiveArgument;
use JetBrains\PhpStorm\Pure;

/**
 * Class DoubleQuotedStringArgument
 */
class DoubleQuotedStringArgument extends DirectiveArgument
{
    /**
     * @return string
     */
    #[Pure] public function asCode(): string
    {
        return sprintf('"%s"', str_replace('"', '\\"', $this->value));
    }

    /**
     * @return bool
     */
    #[Pure] public function isDoubleQuotedString(): bool
    {
        return true;
    }
}
