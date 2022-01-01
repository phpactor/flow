<?php

namespace Phpactor\Flow\Type;

final class StringType extends ComparableType
{
    public function __construct(private ?string $value) {
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
