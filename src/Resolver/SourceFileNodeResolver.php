<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\SourceFileNode;
use Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;

class SourceFileNodeResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof SourceFileNode);

        $statement = null;
        $info = null;
        foreach ($node->statementList as $statement) {
            $info = $interpreter->interpret($frame, $statement);
        }
        /** @phpstan-ignore-next-line */
        if ($statement && $info && $statement instanceof ReturnStatement) {
            return NodeInfo::fromNode($node, $info->type());
        }

        return NodeInfo::fromNode($node);
    }
}
