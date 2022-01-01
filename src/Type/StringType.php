<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

final class StringType extends Type
{
    public function __construct(private ?string $value) {
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
