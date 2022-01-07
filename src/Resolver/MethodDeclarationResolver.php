<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor\DocblockParser\Ast\Tag\ReturnTag;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\MethodDeclarationElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Util\DocblockBridge;
use Phpactor\Flow\Util\NodeBridge;

class MethodDeclarationResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        assert($node instanceof MethodDeclaration);
        $type = NodeBridge::type($node, $node->returnTypeList);

        $docblock = $interpreter->docblock($node->getLeadingCommentAndWhitespaceText());

        foreach ($docblock->descendantElements(ReturnTag::class) as $return) {
            assert($return instanceof ReturnTag);
            $type = DocblockBridge::type($node, $return->type());
        }

        return NodeInfo::fromNode($node, $type);
    }
}
