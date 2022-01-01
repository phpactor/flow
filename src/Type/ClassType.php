<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;
use Phpactor\Name\FullyQualifiedName;

final class ClassType implements Type
{
    public function __construct(private FullyQualifiedName $fqn) {
    }

    public function fqn(): FullyQualifiedName
    {
        return $this->fqn;
    }
}

