<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\Entity;

class SiteNode extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getId() {
        return $this->data['id'];
    }

    public function getName() {
        return $this->data['name'];
    }

    public function getTitle() {
        return $this->data['title'];
    }

    public function getDescription() {
        return $this->data['description'];
    }

    public function getUri() {
        return $this->data['uri'];
    }

    public function getStatus() {
        return $this->data['status'];
    }

    public function getType() {
        return $this->data['type'];
    }

    public function getPath() {
        return $this->data['path'];
    }

}