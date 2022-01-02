<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;
use Phpactor\Flow\Range;
use Phpactor\Flow\Type;

abstract class MemberDeclarationElement extends Element
{
    abstract public function name(): string;
}
