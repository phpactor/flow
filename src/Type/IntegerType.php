<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;
use Phpactor\TextDocument\ByteOffsetRange;

final class IntegerType extends NumericType
{
    public function __construct(private ?int $value)
    {
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
