<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Util\NodeBridge;

class ClassDeclarationResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): Element
    {
        assert($node instanceof ClassDeclaration);

        $memberElements = [];
        /** @phpstan-ignore-next-line */
        foreach ($node?->classMembers?->classMemberDeclarations ?? [] as $member) {
            $memberElements[] = $interpreter->interpret($frame, $member);
        }

        return new ClassDeclarationElement(
            NodeBridge::rangeFromNode($node),
            $memberElements
        );
    }
}
