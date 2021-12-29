<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Phpactor\Flow\Element\UnmanagedElement;

class Interpreter
{
    public function __construct(private readonly array $resolvers = [])
    {
    }

    public function interpret(Node $node)
    {
        if (isset($this->resolvers[$node::class])) {
            return $this->resolvers[$node::class]->resolve($this, $node);
        }

        return new UnmanagedElement(get_class($node), Range::fromNodeOrToken($node));
    }
}
