<?php declare(strict_types=1);

namespace App\Blade;

use App\Blade\Exceptions\InvalidDirectiveArgumentException;
use Illuminate\Support\Collection;

/**
 * Class DirectiveArgumentBag
 * @package App\Blade
 */
class DirectiveArgumentBag extends Collection
{
    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     * @return void
     * @throws InvalidDirectiveArgumentException
     */
    public function __construct(iterable $items = [])
    {
        $arrayableItems = $this->getArrayableItems($items);

        foreach ($arrayableItems as $item) {
            if (!$item instanceof DirectiveArgument) {
                throw new InvalidDirectiveArgumentException(
                    sprintf(
                        "DirectiveArgumentBag should only contain DirectiveArgument instances. %s found.",
                        get_class($item),
                    ),
                );
            }
        }

        parent::__construct($arrayableItems);
    }

    /**
     * @param int $index
     * @return DirectiveArgument|null
     */
    public function index(int $index): ?DirectiveArgument
    {
        return $this->slice($index, 1)->first();
    }

    /**
     * @return Collection
     */
    public function asCollection(): Collection
    {
        return new Collection($this);
    }
}
