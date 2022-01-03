<?php

namespace Phpactor\Flow\SourceLocator;

use Phpactor\Flow\SourceLocator;
use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\TextDocument;

final class NullLocator implements SourceLocator
{
    /**
     * {@inheritDoc}
     */
    public function locate(FullyQualifiedName $name, ?string $type = null): ?TextDocument
    {
        return null;
    }
}
