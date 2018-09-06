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

    public function getSummary() {
        if (isset($this->data['summary'])) {
            return $this->data['summary'];
        } else {
            return null;
        }
    }

    public function getDescription() {
        if (isset($this->data['description'])) {
            return $this->data['description'];
        } else {
            return null;
        }
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

    public function getAuthors() {
        if (isset($this->data['authors'])) {
            return $this->data['authors'];
        } else {
            return null;
        }
    }

    public function getPictureId() {
        if (isset($this->data['picture'])) {
            return $this->data['picture'];
        } else {
            return null;
        }
    }

    public function getSectionPath() {
        return $this->data['pubInfo']['sectionPath'];
    }

    public function getCanonical() {
        if (isset($this->data['pubInfo']['canonical'])) {
            return $this->data['pubInfo']['canonical'];
        } else {
            return null;
        }
    }

    public function getContent() {
        if (isset($this->data['files']) && isset($this->data['files']['content']) && isset($this->data['files']['content']['data'])) {
            return $this->data['files']['content']['data'];
        } else {
            return null;
        }
    }

}