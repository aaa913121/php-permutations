<?php

namespace Nolin\Permutations;

use InvalidArgumentException;

/**
 * Utility class that maintains a small table of prime numbers and provides
 * simple implementations of Prime Factorization algorithms.
 * This is a quick and dirty utility class to support calculations of permutation
 * sets with indexes under 2^31.
 * The prime table contains all primes up to Sqrt(2^31) which are all of the primes
 * required to factorize any Int32 positive integer.
 */
class SmallPrimeUtility
{
    /**
     * 對給定的整數進行質因數分解
     *
     * Performs a prime factorization of a given integer using the table of primes in PrimeTable.
     * Since this will only factor Int32 sized integers, a simple list of factors is returned instead
     * of the more scalable, but more difficult to consume, list of primes and associated exponents.
     *
     * @param int $i The number to factorize, must be positive.
     * @return array A simple list of factors.
     */
    public static function factor(int $i): array
    {
        $primeIndex = 0;
        $prime = self::primeTable()[$primeIndex];
        $factors = [];

        while ($i > 1) {
            $divResult = $i % $prime;

            if ($divResult === 0) {
                $factors[] = $prime;
                $i /= $prime;
            } else {
                ++$primeIndex;
                $prime = self::primeTable()[$primeIndex];
            }
        }

        return $factors;
    }

    /**
     * 建立一個質數表，用來進行質因數分解
     *
     * Static initializer, set up prime table.
     */
    private static function primeTable(): array
    {
        static $primeTable = null;
        if ($primeTable === null) {
            $primeTable = self::calculatePrimes();
        }
        return $primeTable;
    }

    /**
     * Calculate all primes up to Sqrt(2^32) = 2^16.
     * This table will be large enough for all factorizations for Int32's.
     * Small tables are best built using the Sieve Of Eratosthenes,
     * Reference: http://primes.utm.edu/glossary/page.php?sort=SieveOfEratosthenes
     *
     * @return array List of primes.
     */
    private static function calculatePrimes(): array
    {
        // Build Sieve Of Eratosthenes
        $sieve = array_fill(0, 65536, true);
        for ($possiblePrime = 2; $possiblePrime <= 256; ++$possiblePrime) {
            if (!$sieve[$possiblePrime]) {
                continue;
            }
            // It is prime, so remove all future factors...
            for ($nonPrime = 2 * $possiblePrime; $nonPrime < 65536; $nonPrime += $possiblePrime) {
                $sieve[$nonPrime] = false;
            }
        }

        // Scan sieve for primes...
        $primes = [];
        for ($i = 2; $i < 65536; ++$i) {
            if ($sieve[$i]) {
                $primes[] = $i;
            }
        }

        return $primes;
    }

    /**
     * 分母的所有質因數必然都會包含在分子的質因數中
     * 使用遞迴將分母的質因數從分子中移除
     * 這樣就可以得到分子除以分母的結果
     *
     * Given two integers expressed as a list of prime factors, divides these numbers
     * and returns an integer also expressed as a set of prime factors.
     * If the result is not a integer, then the result is undefined.  That is, 11 / 5
     * when divided by this function will not yield a correct result.
     * As such, this function is ONLY useful for division with combinatorial results where
     * the result is known to be an integer AND the division occurs as the last operation(s).
     *
     * @param array $numerator Numerator argument, expressed as list of prime factors.
     * @param array $denominator Denominator argument, expressed as list of prime factors.
     * @return array Resultant, expressed as list of prime factors.
     */
    public static function dividePrimeFactors(array $numerator, array $denominator): array
    {
        $product = $numerator;
        foreach ($denominator as $prime) {
            $key = array_search($prime, $product, true);
            if ($key !== false) {
                unset($product[$key]);
            }
        }
        return array_values($product);
    }

    /**
     * 將分解完的質因數轉換成整數
     *
     * Given a list of prime factors returns the long representation.
     *
     * @param array $value Integer, expressed as list of prime factors.
     * @return int Standard long representation.
     */
    public static function evaluatePrimeFactors(array $value): int
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Value must not be empty.');
        }

        $result = 1;
        foreach ($value as $prime) {
            $result *= $prime;
        }

        return (int)$result;
    }
}
