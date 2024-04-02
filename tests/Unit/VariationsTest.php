<?php

test('can make variations with correct order without repetition', function () {
    $variations = new \Nolin\Permutations\VariationsWithoutRepetition([1, 2, 3], 2);
    $expectVariations = [
        [1, 2],
        [1, 3],
        [2, 1],
        [2, 3],
        [3, 1],
        [3, 2],
    ];

    foreach ($expectVariations as $expectVariation) {
        $this->assertContains($expectVariation, iterator_to_array($variations));
    }

    $this->assertEquals($expectVariations, iterator_to_array($variations));
    $this->assertEquals(6, count($variations));
    $this->assertEquals(6, count(iterator_to_array($variations)));
});

test('can make variations with correct order with repetition', function () {
    $variations = new \Nolin\Permutations\VariationsWithRepetition([1, 2, 3], 2);
    $expectVariations = [
        [1, 1],
        [1, 2],
        [1, 3],
        [2, 1],
        [2, 2],
        [2, 3],
        [3, 1],
        [3, 2],
        [3, 3],
    ];

    foreach ($expectVariations as $expectVariation) {
        $this->assertContains($expectVariation, iterator_to_array($variations));
    }

    $this->assertEquals($expectVariations, iterator_to_array($variations));
    $this->assertEquals(9, count($variations));
    $this->assertEquals(9, count(iterator_to_array($variations)));
});
