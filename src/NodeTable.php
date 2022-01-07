<?php

namespace Phpactor\Flow;

use Microsoft\PhpParser\Node;
use Phpactor\DocblockParser\Ast\Node as DocblockNode;
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

    public function setInfo(Node $node, NodeInfo $info): void
    {
        $this->storage->offsetSet($node, $info);
    }
}
