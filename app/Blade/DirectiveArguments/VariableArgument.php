<?php declare(strict_types=1);

namespace App\Blade\DirectiveArguments;

use App\Blade\DirectiveArgument;
use JetBrains\PhpStorm\Pure;

/**
 * Class VariableArgument
 */
class VariableArgument extends DirectiveArgument
{
    /**
     * @return bool
     */
    #[Pure] public function isVariable(): bool
    {
        return true;
    }
}
