<?php

test('can make combinations without repetition', function () {
    $combinations = new \Nolin\Permutations\Combinations([1, 2, 3, 4, 5, 6], 3);

    $this->assertEquals(20, count($combinations));
});

test('no duplicate combinations without repetition', function () {
    $combinations = new \Nolin\Permutations\Combinations([1, 2, 3], 2);
    $expectCombinations = [
        [1, 2],
        [1, 3],
        [2, 3],
    ];

    foreach ($combinations as $combination) {
        $this->assertContains($combination, $expectCombinations);
    }

    $this->assertEquals(3, count($combinations));
});

test('can make combinations with correct order without repetition', function () {
    $expectCombinations = [
        [1, 2, 3],
        [1, 2, 4],
        [1, 2, 5],
        [1, 2, 6],
        [1, 3, 4],
        [1, 3, 5],
        [1, 3, 6],
        [1, 4, 5],
        [1, 4, 6],
        [1, 5, 6],
        [2, 3, 4],
        [2, 3, 5],
        [2, 3, 6],
        [2, 4, 5],
        [2, 4, 6],
        [2, 5, 6],
        [3, 4, 5],
        [3, 4, 6],
        [3, 5, 6],
        [4, 5, 6],
    ];

    $combinations = new \Nolin\Permutations\Combinations([1, 2, 3, 4, 5, 6], 3);

    $this->assertEquals($expectCombinations, iterator_to_array($combinations));
    $this->assertEquals(20, count($combinations));
});

test('can make combinations with repetition', function () {
    $combinations = new \Nolin\Permutations\Combinations([1, 2, 3, 4, 5, 6], 2, \Nolin\Permutations\Type::WITH_REPETITION);

    $this->assertEquals(21, count($combinations));
});

test('no duplicate combinations with repetition', function () {
    $combinations = new \Nolin\Permutations\Combinations([1, 2, 3], 2, \Nolin\Permutations\Type::WITH_REPETITION);
    $expectCombinations = [
        [1, 1],
        [1, 2],
        [1, 3],
        [2, 2],
        [2, 3],
        [3, 3],
    ];

    foreach ($combinations as $combination) {
        $this->assertContains($combination, $expectCombinations);
    }

    $this->assertEquals(6, count($combinations));
});

test('can make combinations with correct order with repetition', function () {
    $expectCombinations = [
        [1, 1],
        [1, 2],
        [1, 3],
        [1, 4],
        [1, 5],
        [1, 6],
        [2, 2],
        [2, 3],
        [2, 4],
        [2, 5],
        [2, 6],
        [3, 3],
        [3, 4],
        [3, 5],
        [3, 6],
        [4, 4],
        [4, 5],
        [4, 6],
        [5, 5],
        [5, 6],
        [6, 6],
    ];

    $combinations = new \Nolin\Permutations\Combinations([1, 2, 3, 4, 5, 6], 2, \Nolin\Permutations\Type::WITH_REPETITION);

    $this->assertEquals($expectCombinations, iterator_to_array($combinations));
    $this->assertEquals(21, count($combinations));
});
