<?php

namespace Phpactor\Flow\Reflection\Collection;

use Phpactor\Flow\Element\ClassDeclarationElement;
use Phpactor\Flow\Reflection\ReflectionMember;
use Phpactor\Flow\Reflection\ReflectionMethod;
use Phpactor\Flow\Types;

/**
 * @extends MemberCollection<ReflectionMethod>
 */
final class MethodCollection extends MemberCollection
{
    /**
     * @param ReflectionMember[] $members
     */
    public function __construct(private array $members)
    {
    }

    public static function fromElement(ClassDeclarationElement $element, Types $arguments): MethodCollection
    {
    }
}
