<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Phpactor\DocblockParser\Ast\Node as DocblockNode;
use Phpactor\Flow\Type\InvalidType;
use SplObjectStorage;

final class NodeTable
{
    /**
     * @var SplObjectStorage<DocblockNode|Node,NodeInfo>
     */
    private SplObjectStorage $storage;

    final public function __construct()
    {
        $this->storage = new SplObjectStorage();
    }
}
