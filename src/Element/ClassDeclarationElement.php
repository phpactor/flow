<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Token;

class ClassDeclarationElement extends Element
{
    public function __construct(
        private Range $range,
        private DocblockElement $docblock,
        private ?Token $modifier,
        private Token $classKeyword,
        private Token $name,
        private ClassMembersElement $members,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function children(): array
    {
        return array_filter([
            $this->docblock,
            $this->modifier,
            $this->classKeyword,
            $this->name,
            $this->members,
        ]);
    }

    public function members(): ClassMembersElement
    {
        return $this->members;
    }

    public function range(): Range
    {
        return $this->range;
    }

    public function docblock(): DocblockElement
    {
        return $this->docblock;
    }
}
