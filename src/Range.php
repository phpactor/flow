<?php

namespace Phpactor\Flow;

use Phpactor\TextDocument\ByteOffset;

class Range
{
    public function __construct(
        private ByteOffset $fullStart,
        private ByteOffset $start,
        private ByteOffset $end
    ) {
    }

    public function start(): ByteOffset
    {
        return $this->start;
    }

    public function end(): ByteOffset
    {
        return $this->end;
    }

    public function fullStart(): ByteOffset
    {
        return $this->fullStart;
    }
}
