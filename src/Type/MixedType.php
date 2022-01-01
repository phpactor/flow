<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

class MixedType extends ComparableType
{
    public function value(): mixed
    {
        return false;
    }
}
