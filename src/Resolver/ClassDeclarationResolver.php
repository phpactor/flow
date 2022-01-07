<?php

namespace Phpactor\Flow\Resolver;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor\DocblockParser\Ast\Tag\MethodTag;
use Phpactor\Flow\Element;
use Phpactor\Flow\ElementResolver;
use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Element\ClassMembersElement;
use Phpactor\Flow\Element\DocblockElement;
use Phpactor\Flow\Frame;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\NodeInfo;
use Phpactor\Flow\Range;
use Phpactor\Flow\Util\DocblockBridge;
use Phpactor\Flow\Util\NodeBridge;
use Phpactor\TextDocument\ByteOffset;

class ClassDeclarationResolver implements ElementResolver
{
    public function resolve(Interpreter $interpreter, Frame $frame, Node $node): NodeInfo
    {
        return NodeInfo::fromNode($node, NodeBridge::type($node));
    }
}
