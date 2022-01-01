<?php

namespace Phpactor\Flow\Reflection\Collection;

use Phpactor\Flow\Reflection\ReflectionMember;


/**
 * @template T of type ReflectionMember
 */
class MemberCollection
{
    /**
     * @return T
     */
    public function get(string $name): ?ReflectionMember
    {
        return null;
    }
}
