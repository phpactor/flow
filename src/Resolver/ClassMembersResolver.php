<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\ClassMembersNode;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ClassMembersElement;
use Phpactor\Flow\Element\MemberDeclarationElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Util\NodeBridge;

class ClassMembersResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof ClassMembersNode);
        $memberElements = [];
        /** @phpstan-ignore-next-line */
        foreach ($node->classMemberDeclarations ?? [] as $member) {
            $memberElements[] = $interpreter->interpretClass($frame, $member, MemberDeclarationElement::class);
        }

        return new ClassMembersElement(NodeBridge::rangeFromNode($node), $memberElements);
    }
}
