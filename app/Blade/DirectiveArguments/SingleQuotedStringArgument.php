<?php declare(strict_types=1);

namespace App\Blade\DirectiveArguments;

use JetBrains\PhpStorm\Pure;

/**
 * Class SingleQuotedStringArgument
 */
class SingleQuotedStringArgument extends StringArgument
{
    /**
     * @return string
     */
    #[Pure] public function asCode(): string
    {
        return sprintf('\'%s\'', str_replace('\'', '\\\'', $this->value));
    }

    /**
     * @return bool
     */
    #[Pure] public function isSingleQuotedString(): bool
    {
        return true;
    }
}
