<?php

namespace Phpactor\Flow\Reflection\Collection;

use Phpactor\Flow\Reflection\ReflectionMember;

/**
 * @template TMember of ReflectionMember
 */
class MemberCollection
{
    /**
     * @return TMember
     */
    public function get(string $name): ?ReflectionMember
    {
        return null;
    }
}
