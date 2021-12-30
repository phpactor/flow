<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

final class BooleanType extends ComparableType
{
    public function __construct(private ?bool $value) 
    {
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
