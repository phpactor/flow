<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\NamespacedNameInterface;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Parser;
use Phpactor\Name\FullyQualifiedName;

final class AstLocator
{
    public function __construct(private Parser $parser, private SourceLocator $locator)
    {
    }

    /**
     * @param SourceLocator::TYPE_CLASS|SourceLocator::TYPE_FUNCTION|SourceLocator::TYPE_CONSTANT|null $type
     */
    public function locate(FullyQualifiedName $name, ?string $type = null): ?Node
    {
        $code = $this->locator->locate($name);
        $node = $this->parser->parseSourceFile($code);

        foreach ($node->getChildNodes() as $child) {
            if ($child instanceof NamespacedNameInterface) {
                dump($child->getNamespacedName());
            }
        }

        return $node;
    }
}
