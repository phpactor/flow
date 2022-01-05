<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Range;
use Phpactor\Flow\Type;

class MethodDeclarationElement extends MemberDeclarationElement
{
    public function __construct(private Range $range, private string $name, private Type $type)
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return [];
    }

    public function range(): Range
    {
        return $this->range;
    }

    public function type(): Type
    {
        return $this->type;
    }
}
