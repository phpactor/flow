<?php

namespace Phpactor\Flow\Util;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Microsoft\PhpParser\Node\QualifiedName;
use Microsoft\PhpParser\Token;
use Phpactor\Flow\Range;
use Phpactor\Flow\Token as PhpactorToken;
use Phpactor\Flow\Type;
use Phpactor\Flow\Type\ClassType;
use Phpactor\Flow\Type\InvalidType;
use Phpactor\Flow\Type\StringType;
use Phpactor\Flow\Type\UnresolvedType;
use Phpactor\Flow\Types;
use Phpactor\Flow\Type\UnionType;
use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\ByteOffset;
use function is_object;

class NodeBridge
{
    public static function rangeFromNode(Node $node): Range
    {
        return new Range(
            ByteOffset::fromInt($node->getFullStartPosition()),
            ByteOffset::fromInt($node->getStartPosition()),
            ByteOffset::fromInt($node->getEndPosition())
        );
    }

    public static function type(Node $node, null|QualifiedName|QualifiedNameList|Token $parserType = null): Type
    {
        if ($parserType instanceof QualifiedName) {
            return new ClassType(FullyQualifiedName::fromString((string)$parserType));
        }

        if ($parserType instanceof Token) {
            $type = $parserType->getText($node->getFileContents());
            return match ($type) {
                'string' => new StringType(null),
                default => new InvalidType(sprintf(
                    'Do not recognize type "%s"',
                    $type
                ))
            };
        }

        if ($parserType instanceof QualifiedNameList) {
            $types = array_map(
                fn (QualifiedName|Token $t) => self::type($node, $t),
                iterator_to_array($parserType->getValues())
            );
            if (count($types) === 1) {
                return reset($types);
            }
            
            return new UnionType(new Types($types));
        }

        return new UnresolvedType(sprintf(
            'Did not know how to resolve type from "%s"',
            /** @phpstan-ignore-next-line */
            is_object($parserType) ? get_class($parserType) : gettype($parserType)
        ));
    }
}
