<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Cobalt;
use Eidosmedia\Cobalt\Commons\ServiceInfo;
use Eidosmedia\Cobalt\Discovery\Discovery;

class DiscoveryTest extends TestCase {

    private $discoveryUri = 'http://localhost:8480/discovery';

    public function testGetDiscovery() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getDiscovery();
        $this->assertInstanceOf(Discovery::class, $service);
        $serviceInfo = $service->getInfo();
        $this->assertInstanceOf(ServiceInfo::class, $serviceInfo);
        $this->assertEquals($serviceInfo->getType(), 'DISCOVERY');
    }

}