<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

class UndefinedType extends ComparableType
{
    public function value(): mixed
    {
        return false;
    }
}
