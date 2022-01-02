<?php

namespace Phpactor\Flow\Reflection;

use Phpactor\Flow\Type;

final class ReflectionMethod extends ReflectionMember
{
    public function __construct(
        private string $name,
        private Type $type
    )
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): Type
    {
        return $this->type;
    }
}
