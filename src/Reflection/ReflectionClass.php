<?php

namespace Phpactor\Flow\Reflection;

use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Reflection\Collection\MethodCollection;
use Phpactor\Flow\Types;
use Phpactor\Name\FullyQualifiedName;

final class ReflectionClass
{
    public function __construct(private Interpreter $interpreter, private ClassDeclaration $node, private Types $arguments)
    {
    }

    public function methods(): MethodCollection
    {
        return MethodCollection::fromNode($this->interpreter, $this->node, $this->arguments);
    }

    public function name(): FullyQualifiedName
    {
        return FullyQualifiedName::fromString('Example');
    }
}
