<?php

namespace Eidosmedia\Cobalt;

use Eidosmedia\Cobalt\Discovery\Discovery;
use Eidosmedia\Cobalt\Site\Site;

class Cobalt {

    private $discoveryUri;

    public function __construct($discoveryUri) {
        $this->discoveryUri = $discoveryUri;
    }

    public function getDiscovery() {
        $serviceInfo = Discovery::getServiceInfo($this->discoveryUri, 'discovery');
        return new Discovery($serviceInfo);
    }

    public function getSite() {
        $serviceInfo = Discovery::getServiceInfo($this->discoveryUri, 'site');
        return new Site($serviceInfo);
    }

}