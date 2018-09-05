<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\Entity;
use Stringy\StaticStringy as S;

class Sitemap extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getRoot() {
        $rootId = $this->data['root']['id'];
        $node = $this->data['nodes'][$rootId];
        return new NodeData($node);
    }

    public function getMenu($node = null) {
        if (!isset($node) || $node == null) {
            $node = $this->data['root']['id'];
        }
        if (is_string($node) && S::startsWith($node, '/')) {
            $nodeId = $this->getSection($node)->getId();
        } else if ($node instanceof NodeData) {
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

    public function getSection($idOrPath) {
        if (S::startsWith($idOrPath, '/')) {
            foreach ($this->data['nodes'] as $id => $node) {
                if ($node['pubInfo']['sectionPath'] == $idOrPath) {
                    return new NodeData($node);
                }
            }
            return null;
        } else {
            return new NodeData($this->data['nodes'][$idOrPath]);
        }
    }

}