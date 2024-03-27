<?php

test('can make permutations without repetition', function () {
    $permutations = new \Nolin\Permutations\Permutations([1, 2, 3, 4]);

    $this->assertEquals(24, count($permutations));
});

test('can make permutations with repetition', function () {
    $permutations = new \Nolin\Permutations\Permutations([1, 1, 2, 3], \Nolin\Permutations\Type::WITH_REPETITION);

    $this->assertEquals(24, count($permutations));
});
