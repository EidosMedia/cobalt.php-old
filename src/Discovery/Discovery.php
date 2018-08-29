<?php

namespace Eidosmedia\Cobalt\Discovery;

use Eidosmedia\Cobalt\Commons\Service;
use Eidosmedia\Cobalt\Commons\ServiceInfo;
use Eidosmedia\Cobalt\Commons\HttpClient;

class Discovery extends Service {

    public function __construct($serviceInfo) {
        parent::__construct($serviceInfo);
    }

    public static function getServiceInfo($discoveryUri, $type, $domain = null, $zone = null) {
        $httpClient = new HttpClient($discoveryUri);
        $response = $httpClient->get('/services', [
            'domain' => $domain,
            'zone' => $zone,
            'type' => $type,
            'limit' => 1
        ]);
        // FIXME: check result size
        $result = $response['result'][0];
        return new ServiceInfo($result['type'], $result['uri'], $result['id'], $result['domain'], $result['zone']);
    }

}