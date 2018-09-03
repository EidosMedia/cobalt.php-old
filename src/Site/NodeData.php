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

    public function getKind() {
        return $this->data['sys']['kind'];
    }

    public function getBaseType() {
        return $this->data['sys']['baseType'];
    }

    public function getType() {
        return $this->data['sys']['type'];
    }

    public function getCreationTime() {
        return new \DateTime($this->data['sys']['creationTime']);
    }

    public function getCreatedBy($byId = false) {
        return $this->data['sys']['createdBy'][$byId ? 'userId' : 'userName'];
    }

    public function getUpdateTime() {
        return new \DateTime($this->data['sys']['updateTime']);
    }

    public function getUpdatedBy($byId = false) {
        return $this->data['sys']['updatedBy'][$byId ? 'userId' : 'userName'];
    }

}