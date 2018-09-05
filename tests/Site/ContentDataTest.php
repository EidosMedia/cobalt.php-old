<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\ContentData;
use Eidosmedia\Cobalt\Site\NodeData;

class ContentDataTest extends TestCase {

    private $data = [
        'data' => [
            'id' => 'id1'
        ],
        'dataType' => 'type1',
        'nodes' => [
            'id2' => [
                'id' => 'id2'
            ],
            'id3' => [
                'id' => 'id3'
            ]
        ],
        'children' => [
            'id2'
        ],
        'totalPages' => 10,
        'page' => 1
    ];

    public function test() {
        $contentData = new ContentData($this->data);
        // get data
        $nodeData = $contentData->getData();
        $this->assertInstanceOf(NodeData::class, $nodeData);
        $this->assertEquals($nodeData->getId(), $this->data['data']['id']);
        // get data type
        $dataType = $contentData->getDataType();
        $this->assertEquals($dataType, $this->data['dataType']);
        // get nodes
        $nodes = $contentData->getNodes();
        $this->assertContainsOnly('string', array_keys($nodes));
        $this->assertContainsOnlyInstancesOf(NodeData::class, $nodes);
        // get children
        $children = $contentData->getChildren();
        $this->assertContainsOnly('string', $children);
        // get node
        $anId = array_keys($nodes)[0];
        $node = $contentData->getNode($anId);
        $this->assertInstanceOf(NodeData::class, $node);
        $this->assertEquals($node->getId(), $anId);
        // get child nodes
        $childNodes = $contentData->getChildNodes();
        $this->assertContainsOnly('string', array_keys($childNodes));
        $this->assertContainsOnlyInstancesOf(NodeData::class, $childNodes);
        // get total pages
        $totalPages = $contentData->getTotalPages();
        $this->assertEquals($totalPages, $this->data['totalPages']);
        // get page
        $page = $contentData->getPage();
        $this->assertEquals($page, $this->data['page']);
    }

}