<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\SiteNode;

class SiteNodeTest extends TestCase {

    private $data = [
        'id' => '4000-0a84d88996b0-f03fe94b7f78-2001',
        'name' => 'this is the name',
        'title' => 'this is the tile',
        'description' => 'this is the description',
        'uri' => '/this/is/the/uri',
        'status' => 'ENABLED',
        'type' => 'site',
        'path' => '/this/is/the/path'
    ];

    public function test() {
        $siteNode = new SiteNode($this->data);
        // get id
        $id = $siteNode->getId();
        $this->assertInternalType('string', $id);
        $this->assertEquals($id, $this->data['id']);
        // get name
        $name = $siteNode->getName();
        $this->assertInternalType('string', $name);
        $this->assertEquals($name, $this->data['name']);
        // get title
        $title = $siteNode->getTitle();
        $this->assertInternalType('string', $title);
        $this->assertEquals($title, $this->data['title']);
        // get description
        $description = $siteNode->getDescription();
        $this->assertInternalType('string', $description);
        $this->assertEquals($description, $this->data['description']);
        // get uri
        $uri = $siteNode->getUri();
        $this->assertInternalType('string', $uri);
        $this->assertEquals($uri, $this->data['uri']);
        // get status
        $status = $siteNode->getStatus();
        $this->assertInternalType('string', $status);
        $this->assertEquals($status, $this->data['status']);
        // get type
        $type = $siteNode->getType();
        $this->assertInternalType('string', $type);
        $this->assertEquals($type, $this->data['type']);
        // get path
        $path = $siteNode->getPath();
        $this->assertInternalType('string', $path);
        $this->assertEquals($path, $this->data['path']);
    }

}