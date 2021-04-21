<?php declare(strict_types=1);

namespace App\Blade\Services;

use App\Blade\DirectiveArgument;
use App\Blade\DirectiveArguments\BooleanArgument;
use App\Blade\DirectiveArguments\DoubleQuotedStringArgument;
use App\Blade\DirectiveArguments\IntegerArgument;
use App\Blade\DirectiveArguments\RawPhpArgument;
use App\Blade\DirectiveArguments\SingleQuotedStringArgument;
use App\Blade\DirectiveArguments\VariableArgument;
use App\Blade\Exceptions\InvalidDirectiveArgumentException;
use Illuminate\Support\Collection;

/**
 * Class ArgumentsParser
 */
class ArgumentsParser
{
    /**
     * @param string $argumentString
     * @return Collection
     * @throws InvalidDirectiveArgumentException
     */
    public function parseArguments(string $argumentString): Collection
    {
        $cleanedArguments = collect();

        while ($argumentString !== '') {
            if ($cleanedArgument = $this->cleanNextArgument($argumentString)) {
                $cleanedArguments->push($cleanedArgument);
            }

            if ($argumentString !== '' && $argumentString[0] !== ',') {
                throw new InvalidDirectiveArgumentException("Invalid directive argument: " . $argumentString);
            }

            $argumentString = $this->removeSeparator($argumentString);
        }

        return $cleanedArguments;
    }

    /**
     * @param string $argument
     * @return DirectiveArgument
     */
    private function cleanNextArgument(string &$argument): DirectiveArgument
    {
        if (preg_match(
            '/^\s*(?P<quote>[\'"])(?P<string>.*?[^\\\\])\1\s*/',
            $argument,
            $matches
        )) {
            $this->trimString($argument, $matches[0]);

            $argumentClass = match($matches['quote']) {
                '"' => DoubleQuotedStringArgument::class,
                '\'' => SingleQuotedStringArgument::class,
            };

            return new $argumentClass(
                stripslashes($matches['string'])
            );
        }

        if (preg_match('/^\s*(?P<integer>\d+)\s*/', $argument, $matches)) {
            $this->trimString($argument, $matches[0]);
            return new IntegerArgument(
                $matches['integer']
            );
        }

        if (preg_match('/^\s*(?P<boolean>true|false)\s*/i', $argument, $matches)) {
            $this->trimString($argument, $matches[0]);
            return new BooleanArgument(
                $matches['boolean']
            );
        }

        if (preg_match('/^\s*(?P<variable>\$[a-z_][a-z0-9_]*)\s*/i', $argument, $matches)) {
            $this->trimString($argument, $matches[0]);
            return new VariableArgument(
                $matches['variable']
            );
        }

        if (preg_match('/^\s*{(?P<raw_php>.*?[^\\\\])}\s*/', $argument, $matches)) {
            $this->trimString($argument, $matches[0]);
            return new RawPhpArgument(
                str_replace(["\\{", "\\}"], ["{", "}"], $matches['raw_php'])
            );
        }
    }

    /**
     * @param string $argument
     * @return string
     */
    private function removeSeparator(string $argument): string
    {
        if (preg_match('/,\s*/', $argument, $matches)) {
            $this->trimString($argument, $matches[0]);
        }

        return $argument;
    }

    /**
     * @param string $argument
     * @param string $match
     */
    private function trimString(string &$argument, string $match): void
    {
        $argument = substr(
            string: $argument,
            offset: strlen($match)
        );
    }
}
