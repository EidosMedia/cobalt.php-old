<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\Entity;

class Sitemap extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getRoot() {
        $rootId = $this->data['root']['id'];
        $node = $this->data['nodes'][$rootId];
        return new NodeData($node);
    }

    public function getMenu($node) {
        if ($node instanceof NodeData) {
            $nodeId = $node->getId();
        } else {
            $nodeId = $node;
        }
        $node = $this->data['nodes'][$nodeId];
        $childrenIds = $node['hierarchyChildrenIds'];
        $nodes = [];
        foreach ($childrenIds as $childId) {
            array_push($nodes, new NodeData($this->data['nodes'][$childId]));
        }
        return $nodes;
    }

}