<?php

namespace Nolin\Permutations;

use Countable;
use InvalidArgumentException;
use Iterator;
use ReturnTypeWillChange;

class Combinations implements Iterator, Countable
{
    private array $values;
    private int $type;
    private Iterator $permutations;
    private int $currentIndex;

    public function __construct($values, $lowerIndex, Type $type = Type::WITHOUT_REPETITION)
    {
        if (!is_array($values)) {
            throw new InvalidArgumentException('Values must be an array.');
        }
        if (!is_int($lowerIndex) || $lowerIndex < 0) {
            throw new InvalidArgumentException('Lower index must be a non-negative integer.');
        }

        $this->values = $values;
        $this->type = $type->value;
        $this->currentIndex = 0;

        $valueCount = count($values);
        if ($this->type == Type::WITHOUT_REPETITION->value) {
            $map = array_merge(
                array_fill(0, $lowerIndex, false),
                array_fill(0, $valueCount - $lowerIndex, true)
            );
        } else {
            $map = array_merge(
                array_fill(0, $lowerIndex, false),
                array_fill(0, $valueCount - 1, true)
            );
        }

        $this->permutations = (new Permutations($map))->getIterator();
    }

    #[ReturnTypeWillChange] public function rewind(): void
    {
        $this->permutations->rewind();
        $this->permutations = $this->permutations->getIterator();
        $this->currentIndex = 0;
    }

    #[ReturnTypeWillChange] public function key(): int
    {
        return $this->currentIndex;
    }

    #[ReturnTypeWillChange] public function current()
    {
        $currentPermutation = $this->permutations->current();
        return $this->computeCurrent($currentPermutation);
    }

    private function computeCurrent($permutation): array
    {
        $currentList = [];
        $index = 0;
        foreach ($permutation as $p) {
            if (!$p) {
                $currentList[] = $this->values[$index];
                if ($this->type === Type::WITHOUT_REPETITION->value) {
                    $index++;
                }
            } else {
                $index++;
            }
        }
        return $currentList;
    }

    #[ReturnTypeWillChange] public function next(): void
    {
        if ($this->valid()) {
            $this->permutations->next();
            $this->currentIndex++;
        }
    }

    #[ReturnTypeWillChange] public function valid(): bool
    {
        return $this->permutations->valid();
    }

    #[ReturnTypeWillChange] public function count(): int
    {
        return $this->permutations->count();
    }

    public function getType(): int
    {
        return $this->type;
    }
}

