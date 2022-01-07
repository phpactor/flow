<?php

namespace Phpactor\Flow\Reflection;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor\DocblockParser\Ast\Tag\MethodTag;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Type;
use Phpactor\Flow\Util\DocblockBridge;

final class ReflectionMethod extends ReflectionMember
{
    public function __construct(
        private string $name,
        private Type $type
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public static function fromParserNode(Interpreter $interpreter, MethodDeclaration $m): self
    {
        return new self($m->getName(), $interpreter->interpretNoFrame($m)->type());
    }

    public static function fromDocblockNode(Interpreter $interpreter, Node $node, MethodTag $tag): self
    {
        return new self(
            $tag->name->toString(),
            DocblockBridge::type($node, $tag->type)
        );
    }
}
