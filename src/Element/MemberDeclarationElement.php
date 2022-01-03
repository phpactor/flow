<?php

namespace Phpactor\Flow\Element;

use Phpactor\Flow\Element;

abstract class MemberDeclarationElement extends Element
{
    abstract public function name(): string;
}
