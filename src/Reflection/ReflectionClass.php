<?php

namespace Phpactor\Flow\Reflection;

use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Flow;
use Phpactor\Flow\Reflection\Collection\MemberCollection;
use Phpactor\Flow\Reflection\Collection\MethodCollection;
use Phpactor\Name\FullyQualifiedName;

final class ReflectionClass
{
    public function __construct(
    )
    {
    }

    public function methods(): MethodCollection
    {
        return new MethodCollection();
    }

    public function name(): FullyQualifiedName
    {
        return FullyQualifiedName::fromString('Example');
    }
}
