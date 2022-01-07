<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Util\NodeBridge;

class ClassDeclarationResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        return NodeInfo::fromNode($node, NodeBridge::type($node));
    }
}
