<?php declare(strict_types=1);

namespace App\Blade\DirectiveArguments;

use App\Blade\DirectiveArgument;
use JetBrains\PhpStorm\Pure;

/**
 * Class StringArgument
 */
class StringArgument extends DirectiveArgument
{
    /**
     * @return bool
     */
    #[Pure] public function isString(): bool
    {
        return true;
    }
}
