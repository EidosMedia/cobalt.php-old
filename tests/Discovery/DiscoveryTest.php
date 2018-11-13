<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Cobalt;
use Eidosmedia\Cobalt\Commons\ServiceInfo;
use Eidosmedia\Cobalt\Discovery\Discovery;

class DiscoveryTest extends TestCase {

    //private $discoveryUri = 'http://localhost:8480/discovery';
    private $discoveryUri = 'https://demo.eidosmedia.io/discovery';

    public function write($msg) {
        $fh = fopen(date('Ymd') . '.log', 'a+') or die("Unable to open file");
        fwrite($fh, date('Y-m-d H:i:s') . ' ' . $msg . "\n\n");
        fclose($fh);
    }

    public function testGetDiscovery() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getDiscovery();
        $serviceInfo = $service->getInfo();
        $this->write('cobalt ' . json_encode($cobalt));
        $this->write('service ' . json_encode($service));
        $this->write('serviceInfo ' . json_encode($serviceInfo));
        
        $this->assertInstanceOf(Discovery::class, $service);
        $this->assertInstanceOf(ServiceInfo::class, $serviceInfo);
        $this->assertEquals($serviceInfo->getType(), 'DISCOVERY');
    }

}