<?php

namespace Phpactor\Flow\Util;

class DebugHelper
{
    public static function isDebug(): bool
    {
        return getenv('FLOW_DEBUG') ? true : false;
    }
}
