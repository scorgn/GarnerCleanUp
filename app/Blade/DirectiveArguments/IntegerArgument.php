<?php declare(strict_types=1);

namespace App\Blade\DirectiveArguments;

use App\Blade\DirectiveArgument;
use JetBrains\PhpStorm\Pure;

/**
 * Class IntegerDirective
 */
class IntegerArgument extends DirectiveArgument
{
    /**
     * @return bool
     */
    #[Pure] public function isInteger(): bool
    {
        return true;
    }
}
