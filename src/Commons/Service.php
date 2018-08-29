<?php

namespace Eidosmedia\Cobalt\Commons;

abstract class Service {

    private $serviceInfo;
    private $httpClient;

    public function __construct($serviceInfo) {
        $this->serviceInfo = $serviceInfo;
        $this->httpClient = new HttpClient($this->serviceInfo->getUri());
    }

    public function getInfo() {
        return $this->serviceInfo;
    }

    public function getHttpClient() {
        return $this->httpClient;
    }

}