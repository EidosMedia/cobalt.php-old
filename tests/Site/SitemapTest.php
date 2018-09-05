<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\Sitemap;
use Eidosmedia\Cobalt\Site\NodeData;

class SitemapTest extends TestCase {

    private $data = [
        'root' => [
            'id' => '4000-0a84d88996b0-f03fe94b7f78-2001'
        ],
        'nodes' => [
            '4000-0a84d88996b0-f03fe94b7f78-2001' => [
                'id' => '4000-0a84d88996b0-f03fe94b7f78-2001',
                'hierarchyChildrenIds' => [
                    '4000-0a84d88996b0-f03fe94b7f78-2002'
                ],
                'pubInfo' => [
                    'sectionPath' => '/test/'
                ]
            ],
            '4000-0a84d88996b0-f03fe94b7f78-2002' => [
                'id' => '4000-0a84d88996b0-f03fe94b7f78-2002',
                'pubInfo' => [
                    'sectionPath' => '/another/path/'
                ]
            ]
        ]
    ];

    public function test() {
        $sitemap = new Sitemap($this->data);
        // get root
        $root = $sitemap->getRoot();
        $this->assertInstanceOf(NodeData::class, $root);
        // get section
        $section = $sitemap->getSection($root->getId());
        $this->assertInstanceOf(NodeData::class, $section);
        $this->assertEquals($section->getId(), $root->getId());
        // get section by path
        $section = $sitemap->getSection('/test/');
        $this->assertInstanceOf(NodeData::class, $section);
        $this->assertEquals($section->getId(), $root->getId());
        // get section by non existing path
        $section = $sitemap->getSection('/non-existing/');
        $this->assertNull($section);
        // get menu by node
        $menu = $sitemap->getMenu($root);
        $this->assertContainsOnlyInstancesOf(NodeData::class, $menu);
        // get menu by id
        $menu = $sitemap->getMenu($root->getId());
        $this->assertContainsOnlyInstancesOf(NodeData::class, $menu);
        // get root menu
        $menu = $sitemap->getMenu();
        $this->assertContainsOnlyInstancesOf(NodeData::class, $menu);
        // get menu by section path
        $menu = $sitemap->getMenu('/test/');
        $this->assertContainsOnlyInstancesOf(NodeData::class, $menu);
    }

}