<?php

namespace Phpactor\Flow\Type;

use Phpactor\Flow\Type;

/**
 * Type to use when there is an error in the code and the type cannot be
 * resolved.
 */
class InvalidType extends Type
{
    public function __construct(private string $message) {
    }
}
