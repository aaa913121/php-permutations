<?php

test('can make combinations without repetition', function () {
    $combinations = new \Nolin\Permutations\Combinations([1, 2, 3, 4, 5, 6], 3);

    $this->assertEquals(20, count($combinations));
});

test('can make combinations with repetition', function () {
    $combinations = new \Nolin\Permutations\Combinations([1, 2, 3, 4, 5, 6], 2, \Nolin\Permutations\Type::WITH_REPETITION);

    $this->assertEquals(21, count($combinations));
});
