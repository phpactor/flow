<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\AssignmentExpressionElement;
use Phpactor\Flow\Element\VariableElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Util\NodeBridge;

class AssignmentExpressionResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof AssignmentExpression);

        $left = $interpreter->interpret($frame, $node->leftOperand);
        $right = $interpreter->interpret($frame, $node->rightOperand);

        if ($left instanceof VariableElement) {
            $left = $left->withType($right->type());
            $frame->setVariable($left);
        }

        return NodeInfo::fromNode($node);
    }
}
