<?php declare(strict_types=1);

namespace App\Blade;

use App\Blade\DirectiveArguments\BooleanArgument;
use App\Blade\DirectiveArguments\DoubleQuotedStringArgument;
use App\Blade\DirectiveArguments\IntegerArgument;
use App\Blade\DirectiveArguments\RawPhpArgument;
use App\Blade\DirectiveArguments\SingleQuotedStringArgument;
use App\Blade\DirectiveArguments\StringArgument;
use App\Blade\DirectiveArguments\VariableArgument;
use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;

/**
 * Class DirectiveArgument
 * @package App\Providers\Blade
 */
abstract class DirectiveArgument
{
    /** @var string Integer type */
    public const TYPE_INTEGER = IntegerArgument::class;

    /** @var string String type */
    public const TYPE_STRING = StringArgument::class;

    /** @var string Single quoted string type */
    public const TYPE_SINGLE_QUOTED_STRING = SingleQuotedStringArgument::class;

    /** @var string Double quoted string type */
    public const TYPE_DOUBLE_QUOTED_STRING = DoubleQuotedStringArgument::class;

    /** @var string Boolean type */
    public const TYPE_BOOLEAN = BooleanArgument::class;

    /** @var string Variable type */
    public const TYPE_VARIABLE = VariableArgument::class;

    /** @var string Raw PHP type */
    public const TYPE_RAW_PHP = RawPhpArgument::class;

    /** @var string Any type */
    public const TYPE_ANY = self::class;

    /**
     * DirectiveArgument constructor.
     * @param string $value
     */
    public function __construct(protected string $value)
    { }

    /**
     * @return string
     */
    #[Pure] public function getType(): string
    {
        return static::class;
    }

    /**
     * @param string $class
     * @return bool
     */
    #[Pure] public function isType(string $class): bool
    {
        return $this instanceof $class;
    }

    /**
     * @return string
     */
    #[Pure] public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    #[Pure] public function isString(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    #[Pure] public function isDoubleQuotedString(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    #[Pure] public function isSingleQuotedString(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    #[Pure] public function isInteger(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    #[Pure] public function isBoolean(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    #[Pure] public function isVariable(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    #[Pure] public function isRawPHP(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    #[Pure] public function asCode(): string
    {
        return $this->value;
    }
}
