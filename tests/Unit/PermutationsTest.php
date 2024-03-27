<?php

test('can make permutations without repetition', function () {
    $permutations = new \Nolin\Permutations\Permutations([1, 2, 3, 4]);

    $this->assertEquals(24, count($permutations));
});

test('can make permutations with repetition', function () {
    $permutations = new \Nolin\Permutations\Permutations([1, 1, 2, 3], \Nolin\Permutations\Type::WITH_REPETITION);

    $this->assertEquals(24, count($permutations));
});

test('no duplicate permutations', function () {
    $permutations = new \Nolin\Permutations\Permutations([1, 2, 3]);

    $expectPermutations = [
        [1, 2, 3],
        [1, 3, 2],
        [2, 1, 3],
        [2, 3, 1],
        [3, 1, 2],
        [3, 2, 1],
    ];

    foreach ($permutations as $permutation) {
        $this->assertContains($permutation, $expectPermutations);
    }

    $this->assertEquals(6, count($permutations));
});

//test('can make permutations with correct order', function () {
//    $expectPermutations = [
//        [1, 2, 3, 4],
//        [1, 2, 4, 3],
//        [1, 3, 2, 4],
//        [1, 3, 4, 2],
//        [1, 4, 2, 3],
//        [1, 4, 3, 2],
//        [2, 1, 3, 4],
//        [2, 1, 4, 3],
//        [2, 3, 1, 4],
//        [2, 3, 4, 1],
//        [2, 4, 1, 3],
//        [2, 4, 3, 1],
//        [3, 1, 2, 4],
//        [3, 1, 4, 2],
//        [3, 2, 1, 4],
//        [3, 2, 4, 1],
//        [3, 4, 1, 2],
//        [3, 4, 2, 1],
//        [4, 1, 2, 3],
//        [4, 1, 3, 2],
//        [4, 2, 1, 3],
//        [4, 2, 3, 1],
//        [4, 3, 1, 2],
//        [4, 3, 2, 1],
//    ];
//
//    $permutations = new \Nolin\Permutations\Permutations([1, 2, 3, 4]);
//
//    $this->assertEquals($expectPermutations, iterator_to_array($permutations));
//    $this->assertEquals(24, count($permutations));
//});
