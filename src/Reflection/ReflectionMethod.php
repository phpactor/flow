<?php

namespace Phpactor\Flow\Reflection;

final class ReflectionMethod extends ReflectionMember
{
    public function __construct(
        private string $name,
        private ParameterCollection $parameters,
        private Type $type
    )
    {
    }
}
