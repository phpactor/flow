<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Phpactor\Name\FullyQualifiedName;

interface SourceLocator
{
    public const TYPE_CLASS = 'class';
    public const TYPE_FUNCTION = 'function';
    public const TYPE_CONSTANT = 'constant';

    /**
     * @param self::TYPE_CLASS|self::TYPE_FUNCTION|self::TYPE_CONSTANT|null $type
     */
    public function locate(FullyQualifiedName $name, ?string $type = null): Node;
}
