<?php declare(strict_types=1);

namespace App\Blade\Providers;


use App\Blade\DirectiveArgumentBag;
use App\Blade\Directives;
use App\Blade\Services\ArgumentsParser;
use App\Blade\Exceptions\InvalidDirectiveArgumentException;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

/**
 * Class BladeDirectivesProvider
 * @package App\Providers
 */
class DirectivesProvider extends ServiceProvider
{
    /**
     * @param ArgumentsParser $argumentsParser
     * @param BladeCompiler $blade
     * @param Directives    $directives
     * @throws ReflectionException
     */
    public function boot(
        ArgumentsParser $argumentsParser,
        BladeCompiler $blade,
        Directives $directives
    ): void {
        $directivesReflection = new ReflectionClass(get_class($directives));
        $publicMethods = $directivesReflection->getMethods(
            ReflectionMethod::IS_PUBLIC
        );

        foreach ($publicMethods as $method) {
            if ($method->isConstructor()
                || $method->isDestructor()
                || $method->isAbstract()
                || !$method->isUserDefined()
            ) {
                continue;
            }

            $blade->directive(
                $method->getName(),
                fn($argument) => $this->callMethod(
                    $argumentsParser,
                    $directives,
                    $method,
                    $argument,
                ),
            );
        }
    }

    /**
     * @param ArgumentsParser  $argumentsParser
     * @param Directives       $directives
     * @param ReflectionMethod $method
     * @param string           $argument
     * @return string
     * @throws ReflectionException|InvalidDirectiveArgumentException
     */
    private function callMethod(
        ArgumentsParser $argumentsParser,
        Directives $directives,
        ReflectionMethod $method,
        string $argument
    ): string {
        $arguments = $argumentsParser->parseArguments($argument);

        $parameters = collect($method->getParameters());
        $requiredParametersCount = $parameters->filter(
            static fn(ReflectionParameter $parameter) => $parameter->isOptional()
        )->count();
        $methodName = $method->getName();
        $argumentsCount = $arguments->count();

        if ($arguments->count() < $requiredParametersCount) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s::%s expects at least %s parameters, %s given',
                    get_class($directives),
                    $methodName,
                    $requiredParametersCount,
                    $argumentsCount,
                )
            );
        }

        return $method->invoke($directives, new DirectiveArgumentBag($arguments));
    }
}
