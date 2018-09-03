<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\Entity;

class ContentData extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getData() {
        return new NodeData($this->data['data']);
    }

    public function getDataType() {
        return $this->data['dataType'];
    }

    public function getNodes() {
        return array_map(function($el) { return new NodeData($el); }, $this->data['nodes']);
    }

    public function getChildren() {
        return $this->data['children'];
    }

    public function getNode($id) {
        return new NodeData($this->data['nodes'][$id]);
    }

    public function getChildrenNodes() {
        return array_map(function($id) { return $this->getNode($id); }, $this->data['children']);
    }

    public function getTotalPages() {
        return $this->data['totalPages'];
    }

    public function getPage() {
        return $this->data['page'];
    }

}