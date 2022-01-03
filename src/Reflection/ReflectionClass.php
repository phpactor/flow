<?php

namespace Phpactor\Flow\Reflection;

use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Reflection\Collection\MethodCollection;
use Phpactor\Flow\Types;
use Phpactor\Name\FullyQualifiedName;

final class ReflectionClass
{
    public function __construct(private ClassDeclarationElement $element, private Types $arguments)
    {
    }

    public function methods(): MethodCollection
    {
        return MethodCollection::fromElement($this->element, $this->arguments);
    }

    public function name(): FullyQualifiedName
    {
        return FullyQualifiedName::fromString('Example');
    }
}
