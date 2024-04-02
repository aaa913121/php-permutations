# PHP Permutations
This PHP package provides functionalities for generating combinations and permutations. Initially inspired by [eoincampbell/combinatorics](https://github.com/eoincampbell/combinatorics), this package is an adaptation for PHP environments. While translating, some comments may have been lost; however, you can refer to the original files for those details.

## Installation

Install this package via Composer:

`composer require nolin/permutations:dev-master`

## Usage
Once installed, you can use it in your PHP code as follows:

```php
// Include the library
use Nolin\Permutations\Permutations;

// Create a permutations object with an array of elements
$permutations = new Permutations([1, 2, 3, 4, 5]);

// Iterate through the permutations
foreach ($permutations as $permutation) {
    // Perform desired actions with each permutation
    // e.g., echo/print, store in an array, etc.
}

```
## Variations Feature
Variations have been transformed into VariationsWithRepetition and VariationsWithoutRepetition. The C# VariationsWithoutRepetition feature, originally from the source material, was not quite fitting the intended result. As a result, an upgrade has been made to the current() method.

## Package Repository
Feel free to explore the codebase, report issues, or submit pull requests. Your contributions are welcomed and appreciated.
