<?php

namespace Phpactor\Flow\Reflection;

use Phpactor\Flow\Type;
use Phpactor\Flow\Type\UnresolvedType;

abstract class ReflectionMember
{
    public function type(): Type
    {
        return new UnresolvedType('To be implemented');
    }

    abstract public function name(): string;
}
