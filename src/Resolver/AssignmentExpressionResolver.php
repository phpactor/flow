<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;

class AssignmentExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof AssignmentExpression);

        $left = $interpreter->interpret($frame, $node->leftOperand);
        $right = $interpreter->interpret($frame, $node->rightOperand);

        $assignee = $node->leftOperand;
        if ($assignee instanceof Variable) {
            $frame->setVariable($assignee->getName(), $right);
        }

        return NodeInfo::fromNode($node);
    }
}
