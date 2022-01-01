<?php

namespace Phpactor\Flow\Reflection;

use Phpactor\Flow\Reflection\Collection\MemberCollection;
use Phpactor\Name\FullyQualifiedName;

final class ReflectionClass
{
    /**
     * @return MemberCollection<ReflectionMethod>
     */
    public function methods(): MemberCollection
    {
        return new MemberCollection();
    }

    public function name(): FullyQualifiedName
    {
        return FullyQualifiedName::fromString('Example');
    }
}
