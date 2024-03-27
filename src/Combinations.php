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

        $map = [];
        if ($this->type == Type::WITHOUT_REPETITION->value) {
            $valueCount = count($values);
            $map = array_fill(0, $valueCount, false);

            for ($i = 0; $i < $valueCount; $i++) {
                if ($i < $valueCount - $lowerIndex) {
                    $map[$i] = true;
                }
            }
        } else {
            $map = array_merge(array_fill(0, count($values) - 1, true), array_fill(0, $lowerIndex, false));
        }

        $this->permutations = (new Permutations($map))->getIterator();
        $this->rewind();
    }

    #[ReturnTypeWillChange] public function rewind(): void
    {
        $this->permutations->rewind();
        $this->currentIndex = 0;
    }

    #[ReturnTypeWillChange] public function valid(): bool
    {
        return $this->permutations->valid();
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

    #[ReturnTypeWillChange] public function next(): void
    {
        $this->permutations->next();
        $this->currentIndex++;
    }

    #[ReturnTypeWillChange] public function count(): int
    {
        return count($this->permutations);
    }

    public function getType(): int
    {
        return $this->type;
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
}

