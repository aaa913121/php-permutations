<?php

namespace Nolin\Permutations;

use Countable;
use Iterator;
use ReturnTypeWillChange;

class VariationsWithRepetition implements Countable, Iterator
{
    private int $currentIndex;
    private array $currentList;
    private int $upperIndex;
    private array $listIndexes;

    public function __construct(private readonly array $values, private readonly int $lowerIndex)
    {
        $this->rewind();
    }

    public function rewind(): void
    {
        $this->currentIndex = 0;
        $this->currentList = [];
        $this->upperIndex = count($this->values);
        $this->initListIndexes();
    }

    private function initListIndexes(): void
    {
        $this->listIndexes = [];
        for ($i = 0; $i < $this->lowerIndex; ++$i) {
            $this->listIndexes[] = 0;
        }
    }

    public function key(): int
    {
        return $this->currentIndex;
    }

    #[ReturnTypeWillChange] public function current(): array
    {
        foreach ($this->listIndexes as $index) {
            $this->currentList[] = $this->values[$index];
        }

        return $this->currentList;
    }

    public function next(): void
    {
        $carry = 1;

        for ($i = count($this->listIndexes) - 1; $i >= 0 && $carry > 0; --$i) {
            $this->listIndexes[$i] += $carry;
            $carry = 0;

            if ($this->listIndexes[$i] < $this->upperIndex) {
                continue;
            }

            $this->listIndexes[$i] = 0;
            $carry = 1;
        }

        $this->currentList = [];
        ++$this->currentIndex;

    }

    public function valid(): bool
    {
        return $this->currentIndex < $this->count();
    }

    public function count(): int
    {
        return pow($this->upperIndex, $this->lowerIndex);
    }
}
