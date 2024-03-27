<?php

namespace Nolin\Permutations;

enum Position: int
{
    case BEFORE_FIRST = 0;
    case IN_SET = 1;
    case AFTER_LAST = 2;
}
