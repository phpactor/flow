<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

class MixedType extends Type
{
    public function value(): mixed
    {
        return false;
    }
}
