<?php declare(strict_types=1);

namespace App\Blade;

use App\Blade\DirectiveArguments\RawPhpArgument;
use App\Blade\Exceptions\InvalidDirectiveArgumentException;
use Illuminate\Config\Repository as ConfigRepository;
use JetBrains\PhpStorm\Pure;
/**
 * Class BladeDirectives
 */
class Directives
{
    /**
     * Directives constructor.
     * @param ConfigRepository $config
     */
    public function __construct(private ConfigRepository $config)
    {
    }

    /**
     * @param DirectiveArgumentBag $arguments
     * @return string
     * @throws InvalidDirectiveArgumentException
     */
    public function fallbackDefault(DirectiveArgumentBag $arguments): string
    {
        $this->validateDirectiveArguments($arguments, [
            DirectiveArgument::TYPE_ANY,
            DirectiveArgument::TYPE_STRING,
        ], 2);

        return $this->coalesce($this->bag(
            $arguments->first(),
            new RawPhpArgument(var_export(
                config(sprintf('defaults.%s', $arguments->index(1)->getValue())),
                true
            ))
        ));
    }

    /**
     * @param DirectiveArgumentBag $arguments
     * @return string
     */
    public function coalesce(
        DirectiveArgumentBag $arguments,
    ): string {
        return sprintf('<?= %s; ?>', $arguments->asCollection()->map(
            fn (DirectiveArgument $argument) => $argument->asCode()
        )->join(' ?? '));
    }

    /**
     * @param DirectiveArgumentBag $arguments
     * @return string
     * @throws InvalidDirectiveArgumentException
     */
    public function image(DirectiveArgumentBag $arguments): string
    {
        $this->validateDirectiveArguments($arguments, [
            DirectiveArgument::TYPE_STRING,
        ], 1);

        return url(sprintf('images/%s', $arguments->first()->getValue()));
    }

    /**
     * @param DirectiveArgumentBag $arguments
     * @return string
     * @throws InvalidDirectiveArgumentException
     */
    public function imageTag(DirectiveArgumentBag $arguments): string
    {
        $this->validateDirectiveArguments($arguments, [
            DirectiveArgument::TYPE_STRING,
            DirectiveArgument::TYPE_STRING,
            DirectiveArgument::TYPE_STRING,
        ], 1);

        var_dump($arguments);

        $image = $this->image($this->bag($arguments->first()));
        $width = $arguments->index(1);
        $height = $arguments->index(2);
        $altTag = $arguments->index(3);
        $classes = $arguments->index(4);

        return sprintf(
            '<img src="%s" width="%s" height="%s" %s%s>',
            $image,
            $width,
            $height,
            $altTag ? sprintf(' alt="%s"', $altTag->getValue()) : '',
            $classes ? sprintf(' class="%s"', $classes->getValue()) : '',
        );
    }

    /**
     * @param DirectiveArgumentBag $arguments
     * @return string
     * @throws InvalidDirectiveArgumentException
     */
    public function foreachGetter(DirectiveArgumentBag $arguments): string
    {
        $this->validateDirectiveArguments($arguments, [
            DirectiveArgument::TYPE_VARIABLE,
            DirectiveArgument::TYPE_STRING,
            DirectiveArgument::TYPE_STRING,
        ], 3);

        $object = $arguments->index(0);
        $getterMethod = $arguments->index(1);
        $asVariable = $arguments->index(2);

        return sprintf(
            '<?php foreach (%1$s->%2$s() as $%3$s) { ?>',
            $object->asCode(),
            $getterMethod->getValue(),
            $asVariable->getValue()
        );
    }

    /**
     * @return string
     */
    public function breakGetter(): string
    {
        return sprintf('<?php break; ?>');
    }

    public function ifGetterEmpty(DirectiveArgumentBag $arguments): string
    {
        $this->validateDirectiveArguments($arguments, [
            DirectiveArgument::TYPE_VARIABLE,
            DirectiveArgument::TYPE_STRING,
        ], 2);

        $object = $arguments->index(0);
        $getterMethod = $arguments->index(1);

        return sprintf(
            '<?php if (count(%1$s->%2$s()) === 0) { ?>',
            $object,
            $getterMethod
        );
    }

    /**
     * @param DirectiveArgumentBag $arguments
     * @return string
     * @throws InvalidDirectiveArgumentException
     */
    public function ifGetterNotEmpty(DirectiveArgumentBag $arguments): string
    {
        $this->validateDirectiveArguments($arguments, [
            DirectiveArgument::TYPE_VARIABLE,
            DirectiveArgument::TYPE_STRING,
        ], 2);

        $object = $arguments->index(0);
        $getterMethod = $arguments->index(1);

        return sprintf(
            '<?php if (count(%1$s->%2$s()) > 0) { ?>',
            $object->asCode(),
            $getterMethod->getValue()
        );
    }

    /**
     * @return string
     */
    public function elseGetter(): string
    {
        return '<?php } else { ?>';
    }

    /**
     * @return string
     */
    public function endforeachGetter(): string
    {
        return '<?php } ?>';
    }

    /**
     * @return string
     */
    public function endifGetter(): string
    {
        return '<?php } ?>';
    }

    /**
     * @param DirectiveArgumentBag $arguments
     * @param array                $types
     * @param int|null             $requiredArguments
     * @param bool                 $throwException
     * @return bool
     * @throws InvalidDirectiveArgumentException
     */
    private function validateDirectiveArguments(
        DirectiveArgumentBag $arguments,
        array $types,
        int $requiredArguments = null,
        bool $throwException = true,
    ): bool {
        $argumentsCount = $arguments->count();

        if ($requiredArguments !== null && $argumentsCount < $requiredArguments) {
            return $throwException === false
                ? false
                : throw new InvalidDirectiveArgumentException(sprintf(
                    "This directive requires %s arguments, but only %s were provided.",
                    $requiredArguments,
                    $argumentsCount,
                ));
        }

        $i = 0;

        /** @var DirectiveArgument $argument */
        foreach ($arguments->all() as $argument) {
            $i++;

            $type = array_shift($types);
            if (!$this->validateDirectiveArgument($type, $argument)) {
                return $throwException === false
                    ? false
                    : $this->throwInvalidTypeException($argument, $type, $i);
            }
        }

        return true;
    }

    /**
     * @param DirectiveArgumentBag $arguments
     * @return string
     * @throws InvalidDirectiveArgumentException
     */
    public function config(DirectiveArgumentBag $arguments)
    {
        $this->validateDirectiveArguments($arguments, [
            DirectiveArgument::TYPE_STRING,
        ], 1);

        $config = $arguments->first();
        $value = config(
            sprintf('defaults.%s', $config->getValue())
        ) ?? '';

        return $value ?? '';
    }

    /**
     * @param DirectiveArgument $argument
     * @param string|array      $type
     * @param int|null          $iteration
     * @return bool
     * @throws InvalidDirectiveArgumentException
     */
    private function throwInvalidTypeException(
        DirectiveArgument $argument,
        string|array $type,
        ?int $iteration
    ): bool {
        if (is_array($type)) {
            $allowedClasses = array_map(
                fn ($class) => $this->getBaseClassName($class),
                $type
            );

            $allowedClasses = implode(", ", $allowedClasses);
        } else {
            $allowedClasses = $this->getBaseClassName($type);
        }

        throw new InvalidDirectiveArgumentException(sprintf(
            "Argument %s should be: %s. %s given.",
            $iteration,
            $allowedClasses,
            $this->getBaseClassName($argument->getType())
        ));
    }

    /**
     * @param string $className
     * @return string
     */
    private function getBaseClassName(string $className): string
    {
        $classParts = explode("\\", $className);
        return array_pop($classParts);
    }

    /**
     * @param string|array|null $type
     * @param DirectiveArgument $argument
     * @return bool
     */
    #[Pure] private function validateDirectiveArgument(
        string|array|null $type,
        DirectiveArgument $argument,
    ): bool {
        if ($type === null) {
            return true;
        }

        if (is_array($type)) {
            foreach ($type as $individualType) {
                if ($argument->isType($individualType)) {
                    return true;
                }
            }

            return false;
        }

        return $argument->isType($type);
    }

    /**
     * @param mixed ...$values
     * @return DirectiveArgumentBag
     * @throws InvalidDirectiveArgumentException
     */
    private function bag(...$values): DirectiveArgumentBag
    {
        $values = count($values) === 1 && is_array(current($values))
            ? array_shift($values)
            : $values;

        return new DirectiveArgumentBag($values);
    }
}
