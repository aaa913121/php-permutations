<?php
test('can make permutations with correct order without repetition', function () {
    $permutations = new \Nolin\Permutations\Permutations([1, 2, 3, 4]);
    $expectPermutations = [
        [1, 2, 3, 4],
        [1, 2, 4, 3],
        [1, 3, 2, 4],
        [1, 3, 4, 2],
        [1, 4, 2, 3],
        [1, 4, 3, 2],
        [2, 1, 3, 4],
        [2, 1, 4, 3],
        [2, 3, 1, 4],
        [2, 3, 4, 1],
        [2, 4, 1, 3],
        [2, 4, 3, 1],
        [3, 1, 2, 4],
        [3, 1, 4, 2],
        [3, 2, 1, 4],
        [3, 2, 4, 1],
        [3, 4, 1, 2],
        [3, 4, 2, 1],
        [4, 1, 2, 3],
        [4, 1, 3, 2],
        [4, 2, 1, 3],
        [4, 2, 3, 1],
        [4, 3, 1, 2],
        [4, 3, 2, 1],
    ];

    foreach ($expectPermutations as $expectPermutation) {
        $this->assertContains($expectPermutation, iterator_to_array($permutations));
    }

    $this->assertEquals($expectPermutations, iterator_to_array($permutations));
    $this->assertEquals(24, count($permutations));
    $this->assertEquals(24, count(iterator_to_array($permutations)));
});

test('can make permutations with correct order with repetition', function () {
    $permutations = new \Nolin\Permutations\Permutations([1, 2, 3, 3], \Nolin\Permutations\Type::WITH_REPETITION);
    $expectPermutations = [
        [1, 2, 3, 3],
        [1, 2, 3, 3],
        [1, 3, 2, 3],
        [1, 3, 3, 2],
        [1, 3, 2, 3],
        [1, 3, 3, 2],
        [2, 1, 3, 3],
        [2, 1, 3, 3],
        [2, 3, 1, 3],
        [2, 3, 3, 1],
        [2, 3, 1, 3],
        [2, 3, 3, 1],
        [3, 1, 2, 3],
        [3, 1, 3, 2],
        [3, 2, 1, 3],
        [3, 2, 3, 1],
        [3, 3, 1, 2],
        [3, 3, 2, 1],
        [3, 1, 2, 3],
        [3, 1, 3, 2],
        [3, 2, 1, 3],
        [3, 2, 3, 1],
        [3, 3, 1, 2],
        [3, 3, 2, 1],
    ];

    foreach ($expectPermutations as $expectPermutation) {
        $this->assertContains($expectPermutation, iterator_to_array($permutations));
    }

    $this->assertEquals($expectPermutations, iterator_to_array($permutations));
    $this->assertEquals(24, count($permutations));
    $this->assertEquals(24, count(iterator_to_array($permutations)));
});
