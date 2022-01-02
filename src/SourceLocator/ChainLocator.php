<?php

namespace Phpactor\Flow\SourceLocator;

use Phpactor\Flow\SourceLocator;
use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\TextDocument;

class ChainLocator implements SourceLocator
{
    /**
     * @param SourceLocator[] $locators
     */
    public function __construct(private array $locators)
    {
    }

    public function locate(FullyQualifiedName $name, ?string $type = null): ?TextDocument
    {
        foreach ($this->locators as $locator) {
            $textDocument = $locator->locate($name, $type);
            if (!$textDocument) {
                continue;
            }

            return $textDocument;
        }

        return null;
    }
}

