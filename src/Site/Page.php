<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\Entity;

class Page extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getModel() {
        return new ContentData($this->data['model']);
    }

    public function getSiteNode() {
        return new SiteNode($this->data['siteNode']);
    }

    public function getSiteData() {
        return new SiteData($this->data['siteData']);
    }

}