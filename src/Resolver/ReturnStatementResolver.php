<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;

final class ReturnStatementResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof ReturnStatement);
        return NodeInfo::fromNode(
            $node,
            $interpreter->interpret($frame, $node->expression)->type()
        );
    }
}
