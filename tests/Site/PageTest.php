<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\Page;
use Eidosmedia\Cobalt\Site\ContentData;
use Eidosmedia\Cobalt\Site\NodeData;
use Eidosmedia\Cobalt\Site\SiteNode;
use Eidosmedia\Cobalt\Site\SiteData;

class PageTest extends TestCase {

    private $data = [
        'model' => [
            'data' => [
                'id' => 'id1'
            ],
            'nodes' => [
                'id2' => [
                    'id' => 'id2'
                ]
            ]
        ],
        'siteNode' => [

        ],
        'siteData' => [

        ],
        'resourcesUrls' => [
            'id2' => '/resource/url'
        ],
        'nodesUrls' => [
            'id2' => '/node/url'
        ]
    ];

    public function test() {
        $page = new Page($this->data);
        // get model
        $model = $page->getModel();
        $this->assertInstanceOf(ContentData::class, $model);
        // get current object
        $currentObject = $page->getCurrentObject();
        $this->assertInstanceOf(NodeData::class, $currentObject);
        // get site node
        $siteNode = $page->getSiteNode();
        $this->assertInstanceOf(SiteNode::class, $siteNode);
        // get site data
        $siteData = $page->getSiteData();
        $this->assertInstanceOf(SiteData::class, $siteData);
        // get url node and resource
        $anId = array_keys($model->getNodes())[0];
        $url = $page->getUrl($anId);
        $this->assertEquals($url, $this->data['nodesUrls'][$anId]);
        $url = $page->getResourceUrl($anId);
        $this->assertEquals($url, $this->data['resourcesUrls'][$anId]);
    }

}