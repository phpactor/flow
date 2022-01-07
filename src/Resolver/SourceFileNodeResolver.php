<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\SourceFileNode;
use Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Microsoft\PhpParser\SomeNode;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Util\NodeBridge;

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
        if ($statement && $info && $statement instanceof ReturnStatement) {
            return NodeInfo::fromNode($node, $info->type());
        }

        return NodeInfo::fromNode($node);
    }
}

