This is a service that can do combinations and permutations with PHP.
The origin idea is from [eoincampbell/combinatorics](https://github.com/eoincampbell/combinatorics), while I want to try it in PHP environment, so I translate it with chatGPT.
Some comment might be lost while translating, you can read them from the origin files.

## How to use

Include this library in your project by doing:

`composer require nolin/permutations:dev-master`

And use it in your code like this:

```php
// Create the object
$permutations = new \Nolin\Permutations\Permutations([1,2,3,4,5]);

foreach ($permutations as $permutation) {
  // do something
}

```
