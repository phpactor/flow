<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Parser;
use Phpactor\Flow\Reflection\ReflectionClass;
use Phpactor\Name\FullyQualifiedName;

class Reflector implements ClassReflector
{
    public function __construct() {
    }

    public function reflectClass(FullyQualifiedName $name, ?Types $parameters = null): ReflectionClass
    {
        return new ReflectionClass();
    }
}
