<?php

namespace Phpactor\Flow\Reflection\Collection;

use Phpactor\Flow\Reflection\ReflectionMember;

/**
 * @template TMember of ReflectionMember
 */
class MemberCollection
{
    /**
     * @param TMember[] $members
     */
    public function __construct(private array $members)
    {
    }

    /**
     * @return TMember
     */
    public function get(string $name): ?ReflectionMember
    {
        foreach ($this->members as $member) {
            if ($member->name() === $name) {
                return $member;
            }
        }

        return null;
    }
}
