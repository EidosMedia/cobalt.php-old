<?php

namespace Eidosmedia\Cobalt\Commons;

class ServiceInfo {

    private $type;
    private $uri;
    private $id;
    private $domain;
    private $zone;

    public function __construct($type, $uri, $id = null, $domain = null, $zone = null) {
        $this->type = $type;
        $this->uri = $uri;
        $this->id = $id;
        $this->domain = $domain;
        $this->zone = $zone;
    }

    // @codeCoverageIgnoreStart
    public function __toString() {
        return 'ServiceInfo[type=' . $this->type . 
            ', uri=' . $this->uri . 
            ', id=' . $this->id . 
            ', domain=' . $this->domain .
            ', zone=' . $this->zone .
            ']';
    }
    // @codeCoverageIgnoreEnd

    public function getType() {
        return $this->type;
    }

    public function getUri() {
        return $this->uri;
    }

}