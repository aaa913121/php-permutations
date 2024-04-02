<?php

namespace Nolin\Permutations;

use Countable;
use Iterator;
use ReturnTypeWillChange;

class VariationsWithoutRepetition implements Countable, Iterator
{
    private Iterator $permutations;
    private int $currentIndex;
    private array $currentList;

    public function __construct(readonly array $values, private readonly int $lowerIndex)
    {
        $this->currentIndex = 0;
        $this->currentList = [];
        $this->permutations = (new Permutations($values))->getIterator();
    }

    public function rewind(): void
    {
        $this->permutations->rewind();
        $this->permutations = $this->permutations->getIterator();
        $this->currentIndex = 0;
    }

    public function key(): int
    {
        return $this->currentIndex;
    }

    #[ReturnTypeWillChange] public function current(): array
    {
        $currentPermutation = $this->permutations->current();

        // get only the $lowerIndex values from the current permutation
        for ($i = 0; $i < $this->lowerIndex; ++$i) {
            $this->currentList[] = $currentPermutation[$i];
        }

        return $this->currentList;
    }

    public function next(): void
    {
        $this->permutations->next();
        ++$this->currentIndex;
        $this->currentList = [];
    }

    public function valid(): bool
    {
        return $this->permutations->valid();
    }

    public function count(): int
    {
        return $this->permutations->count();
    }
}
