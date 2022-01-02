<?php

namespace Phpactor\Flow;

use Phpactor\Flow\Reflection\ReflectionClass;
use Phpactor\Name\FullyQualifiedName;

interface ClassReflector
{
    public function reflectClass(FullyQualifiedName $name, ?Types $parameters = null): ReflectionClass;
}
