<?php

namespace Phpactor\Flow\SourceLocator;

use Phpactor\Flow\SourceLocator;
use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\TextDocument;
use Phpactor\TextDocument\TextDocumentBuilder;

final class StringLocator implements SourceLocator
{
    private TextDocument $document;

    public function __construct(TextDocument $document)
    {
        $this->document = $document;
    }

    public static function fromString(string $string): self
    {
        return new self(TextDocumentBuilder::create($string)->build());
    }

    /**
     * {@inheritDoc}
     */
    public function locate(FullyQualifiedName $name, ?string $type = null): ?TextDocument
    {
        return $this->document;
    }
}
