<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\ArgumentExpression;
use Phpactor\DocblockParser\Ast\Node as DocblockNode;
use Phpactor\Flow\Type\InvalidType;

final class NodeInfo
{
    private function __construct(private Type $type)
    {
    }

    public function type(): Type
    {
        return $this->type;
    }

    public static function fromNode(DocblockNode|Node $node, ?Type $type = null): self
    {
        return new self($type ?? new InvalidType(sprintf(
            'Node of type "%s" has not got a type associated with it',
            $node::class
        )));
    }
}
