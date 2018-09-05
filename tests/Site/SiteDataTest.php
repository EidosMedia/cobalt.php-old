<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\SiteData;

class SiteDataTest extends TestCase {

    private $data = [
        'siteName' => 'site-name',
        'viewStatus' => 'LIVE',
        'rootId' => '4000-0a84d88996b0-f03fe94b7f78-2001',
        'title' => 'this is the tile',
        'description' => 'this is the description'
    ];

    public function test() {
        $siteData = new SiteData($this->data);
        // get site name
        $siteName = $siteData->getSiteName();
        $this->assertInternalType('string', $siteName);
        $this->assertEquals($siteName, $this->data['siteName']);
        // get view status
        $viewStatus = $siteData->getViewStatus();
        $this->assertInternalType('string', $viewStatus);
        $this->assertEquals($viewStatus, $this->data['viewStatus']);
        // get root id
        $rootId = $siteData->getRootId();
        $this->assertInternalType('string', $rootId);
        $this->assertEquals($rootId, $this->data['rootId']);
        // get title
        $title = $siteData->getTitle();
        $this->assertInternalType('string', $title);
        $this->assertEquals($title, $this->data['title']);
        // get description
        $description = $siteData->getDescription();
        $this->assertInternalType('string', $description);
        $this->assertEquals($description, $this->data['description']);
    }

}