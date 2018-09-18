<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\ContentData;
use Eidosmedia\Cobalt\Site\NodeData;

class ContentDataTest extends TestCase {

    private $data = [
        'data' => [
            'id' => 'id0',
            'files' => [
                'templates' => [
                    'data' => [
                        't1' => [
                            'zones' => [
                                'z1' => [
                                    'name' => 'z1',
                                    'sequences' => [[
                                        'maxItems' => 1
                                    ], [
                                        'maxItems' => 2
                                    ]]
                                ],
                                'z2' => [
                                    'name' => 'z2',
                                    'sequences' => [[
                                        'maxItems' => 3
                                    ]]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'attributes' => [
                'template' => 't1'
            ],
            'links' => [
                'pagelink' => [
                    'z1' => [[
                        'targetId' => 'id1'
                    ], [
                        'targetId' => 'id2'
                    ], [
                        'targetId' => 'id3'
                    ], [
                        'targetId' => 'id4'
                    ], [
                        'targetId' => 'id5'
                    ]],
                    'z2' => [[
                        'targetId' => 'id6'
                    ], [
                        'targetId' => 'id7'
                    ]]
                ]
            ]
        ],
        'dataType' => 'type1',
        'nodes' => [
            'id1' => [
                'id' => 'id1'
            ],
            'id2' => [
                'id' => 'id2'
            ],
            'id3' => [
                'id' => 'id3'
            ],
            'id4' => [
                'id' => 'id4'
            ],
            'id5' => [
                'id' => 'id5'
            ],
            'id6' => [
                'id' => 'id6'
            ],
            'id7' => [
                'id' => 'id7'
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
        // get zones names
        $zonesNames = $contentData->getZonesNames();
        $this->assertContainsOnly('string', $zonesNames);
        // get zone nodes
        $zoneNodes = $contentData->getZoneNodes('z1');
        $this->assertContainsOnlyInstancesOf(NodeData::class, $zoneNodes);
    }

}