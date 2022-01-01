<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

/**
 * Type for when Phpactor did not know how to resolve a type
 */
class UnresolvedType extends Type
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
