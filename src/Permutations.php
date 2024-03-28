<?php

namespace Nolin\Permutations;

use Countable;
use Iterator;
use ReturnTypeWillChange;


/**
 * Permutations defines a sequence of all possible orderings of a set of values.
 */
class Permutations implements Iterator, Countable
{
    private array $values;
    private array $lexicographicOrders;
    private int $count;
    private int $type;
    private int $currentIndex;
    private array $originalValues;

    /**
     * Create a permutation set from the provided list of values.
     * The values (T) must implement IComparable.
     * If T does not implement IComparable use a constructor with an explicit IComparer.
     * The repetition type defaults to MetaCollectionType.WithholdRepetitionSets
     *
     * @param array $values List of values to permute.
     */
    public function __construct(array $values, Type $type = Type::WITHOUT_REPETITION)
    {
        $this->values = $values;
        $this->type = $type->value;
        $this->currentIndex = 0;
        $this->originalValues = $values;
        $this->init();
    }

    private function init(): void
    {
        $this->values = $this->originalValues;
        $this->currentIndex = 0;

        $this->lexicographicOrders = range(0, count($this->values) - 1);

        if ($this->type === Type::WITHOUT_REPETITION->value) {
            sort($this->values);
            $j = 1;
            $this->lexicographicOrders[0] = $j;

            for ($i = 1; $i < count($this->lexicographicOrders); ++$i) {
                if ($this->values[$i - 1] !== $this->values[$i]) {
                    ++$j;
                }
                $this->lexicographicOrders[$i] = $j;
            }
        } else {
            for ($i = 1; $i < count($this->lexicographicOrders); ++$i) {
                $this->lexicographicOrders[$i] = $i;
            }
        }

        $this->count = $this->getCount();
    }

    /**
     * 排列組合的計算結果通常都是整數，所以分母的所有質因數必然都會包含在分子的質因數中
     *
     *  Calculates the total number of permutations that will be returned.
     *  As this can grow very large, extra effort is taken to avoid overflowing the accumulator.
     *  While the algorithm looks complex, it really is just collecting numerator and denominator terms
     *  and cancelling out all of the denominator terms before taking the product of the numerator terms.
     * @return int
     */
    private function getCount(): int
    {
        // runCount是用來計算相同的數字出現的次數，需要將之前的次數所使用的數字的質因數納入到 divisors 中
        $runCount = 1;
        // divisors 是用來存放分母的質因數
        $divisors = [];
        // numerators 是用來存放分子的質因數
        $numerators = [];

        for ($i = 1; $i < count($this->lexicographicOrders); ++$i) {
            // 將下一個數字(i + 1) 的質因數添加到 numerators(起始點的1不用做)
            $numerators = array_merge($numerators, SmallPrimeUtility::factor($i + 1));
            // 如果當前數字和前一個數字相同，則 runCount + 1
            if ($this->lexicographicOrders[$i] == $this->lexicographicOrders[$i - 1]) {
                ++$runCount;
            } else {
                // 如果當前數字和前一個數字不同，則將 runCount 的質因數添加到 divisors
                for ($f = 2; $f <= $runCount; ++$f) {
                    $divisors = array_merge($divisors, SmallPrimeUtility::factor($f));
                }
                $runCount = 1;
            }
        }


        for ($f = 2; $f <= $runCount; ++$f) {
            $divisors = array_merge($divisors, SmallPrimeUtility::factor($f));
        }

        return SmallPrimeUtility::evaluatePrimeFactors(SmallPrimeUtility::dividePrimeFactors($numerators, $divisors));
    }


    #[ReturnTypeWillChange] public function rewind(): void
    {
        $this->init();
    }

    /**
     * Gets an enumerator for collecting the list of permutations.
     *
     * @return Iterator
     */
    public function getIterator(): Iterator
    {
        return new self($this->values);
    }

    #[ReturnTypeWillChange] public function current(): array
    {
        return $this->values;
    }

    #[ReturnTypeWillChange] public function key(): int
    {
        return $this->currentIndex;
    }

    #[ReturnTypeWillChange] public function next(): void
    {
        $this->currentIndex++;
        $this->nextPermutation();
    }

    private function nextPermutation(): void
    {
        $i = count($this->lexicographicOrders) - 1;

        while ($this->lexicographicOrders[$i - 1] >= $this->lexicographicOrders[$i]) {
            --$i;
            if ($i === 0) {
                return;
            }
        }

        $j = count($this->lexicographicOrders);

        while ($this->lexicographicOrders[$j - 1] <= $this->lexicographicOrders[$i - 1]) {
            --$j;
        }

        $this->swap($i - 1, $j - 1);

        ++$i;

        $j = count($this->lexicographicOrders);

        while ($i < $j) {
            $this->swap($i - 1, $j - 1);
            ++$i;
            --$j;
        }
    }

    private function swap(int $i, int $j): void
    {
        $temp = $this->values[$i];
        $this->values[$i] = $this->values[$j];
        $this->values[$j] = $temp;
        $temp = $this->lexicographicOrders[$i];
        $this->lexicographicOrders[$i] = $this->lexicographicOrders[$j];
        $this->lexicographicOrders[$j] = $temp;
    }

    #[ReturnTypeWillChange] public function valid(): bool
    {
        return $this->currentIndex >= 0 && $this->currentIndex <= $this->count -1;
    }

    public function count(): int
    {
        return $this->count;
    }
}


