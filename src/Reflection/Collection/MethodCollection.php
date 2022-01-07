<?php

namespace Phpactor\Flow\Reflection\Collection;

use Generator;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor\DocblockParser\Ast\Tag\MethodTag;
use Phpactor\Flow\Interpreter;
use Phpactor\Flow\Reflection\ReflectionMethod;
use Phpactor\Flow\Types;
use function iterator_to_array;

/**
 * @extends MemberCollection<ReflectionMethod>
 */
final class MethodCollection extends MemberCollection
{
    public static function fromNode(Interpreter $interpreter, ClassDeclaration $node, Types $arguments): MethodCollection
    {
        return new MethodCollection(
            iterator_to_array(
                (function () use ($node, $interpreter): Generator {
                    foreach ($interpreter->docblock(
                        $node->getLeadingCommentAndWhitespaceText()
                    )->descendantElements(MethodTag::class) as $m) {
                        assert($m instanceof MethodTag);
                        yield ReflectionMethod::fromDocblockNode($interpreter, $node, $m);
                    }
                    /** @phpstan-ignore-next-line */
                    foreach ($node->classMembers?->getChildNodes() ?? [] as $m) {
                        if (!$m instanceof MethodDeclaration) {
                            continue;
                        }
                        yield ReflectionMethod::fromParserNode($interpreter, $m);
                    }
                })()
            )
        );
    }
}
