<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;

class ClassMembersElement extends Element
{
    /**
     * @param MemberDeclarationElement[] $members
     */
    public function __construct(private Range $range, private array $members)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return $this->members;
    }

    public function range(): Range
    {
        return $this->range;
    }
}
