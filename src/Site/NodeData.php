<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\Entity;

class NodeData extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getId() {
        return $this->data['id'];
    }

    public function getParentId() {
        return $this->data['parentId'];
    }

    public function getName() {
        return $this->data['name'];
    }

    public function getTitle() {
        return $this->data['title'];
    }

}