<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\NodeData;

class NodeDataTest extends TestCase {

    private $data = [
        'id' => '4000-0a84d88996b0-f03fe94b7f78-2001',
        'parentId' => '4000-0a82648d112e-2892b4e26fe3-2000',
        'name' => 'this is the name',
        'title' => 'this is the tile',
        'summary' => 'this is the summary',
        'description' => 'this is the description',
        'authors' => [ 'ale', 'ber' ],
        'picture' => '4000-0a82648d112e-2892b4e26fe3-2000',
        'sys' => [
            'kind' => 'content',
            'baseType' => 'article',
            'type' => 'longform',
            'creationTime' => '2018-08-30T09:38:10.298Z',
            'updateTime' => '2018-08-30T09:38:10.298Z',
            'createdBy' => [
                'userName' => 'aleber',
                'userId' => '123'
            ],
            'updatedBy' => [
                'userName' => 'aleber',
                'userId' => '123'
            ]
        ],
        'pubInfo' => [
            'sectionPath' => '/this/is/a/test',
            'canonical' => '/this/is/a/canonical'
        ],
        'files' => [
            'content' => [
                'data' => '<document><content><h1>content</h1></content></document>'
            ]
        ]
    ];

    private $emptyData = [
        'pubInfo' => []
    ];

    public function test() {
        $nodeData = new NodeData($this->data);
        $emptyNodeData = new NodeData($this->emptyData);
        // get id
        $id = $nodeData->getId();
        $this->assertInternalType('string', $id);
        $this->assertEquals($id, $this->data['id']);
        // get parent id
        $parentId = $nodeData->getParentId();
        $this->assertInternalType('string', $parentId);
        $this->assertEquals($parentId, $this->data['parentId']);
        // get name
        $name = $nodeData->getName();
        $this->assertInternalType('string', $name);
        $this->assertEquals($name, $this->data['name']);
        // get title
        $title = $nodeData->getTitle();
        $this->assertInternalType('string', $title);
        $this->assertEquals($title, $this->data['title']);
        // get description
        $description = $nodeData->getDescription();
        $this->assertInternalType('string', $description);
        $this->assertEquals($description, $this->data['description']);
        // get description - not defined
        $description = $emptyNodeData->getDescription();
        $this->assertNull($description);
        // get summary
        $summary = $nodeData->getSummary();
        $this->assertInternalType('string', $summary);
        $this->assertEquals($summary, $this->data['summary']);
        // get summary - not defined
        $summary = $emptyNodeData->getSummary();
        $this->assertNull($summary);
        // get kind
        $kind = $nodeData->getKind();
        $this->assertInternalType('string', $kind);
        $this->assertEquals($kind, $this->data['sys']['kind']);
        // get type
        $type = $nodeData->getType();
        $this->assertInternalType('string', $type);
        $this->assertEquals($type, $this->data['sys']['type']);
        // get base type
        $baseType = $nodeData->getBaseType();
        $this->assertInternalType('string', $baseType);
        $this->assertEquals($baseType, $this->data['sys']['baseType']);
        // get creation time
        $creationTime = $nodeData->getCreationTime();
        $this->assertInstanceOf(\DateTime::class, $creationTime);
        $this->assertEquals($creationTime->format('Y-m-d\TH:i:s.v\Z'), $this->data['sys']['creationTime']);
        // get update time
        $updateTime = $nodeData->getUpdateTime();
        $this->assertInstanceOf(\DateTime::class, $updateTime);
        $this->assertEquals($updateTime->format('Y-m-d\TH:i:s.v\Z'), $this->data['sys']['updateTime']);
        // get created by
        $createdByUserId = $nodeData->getCreatedBy(true);
        $this->assertInternalType('string', $createdByUserId);
        $this->assertEquals($createdByUserId, $this->data['sys']['createdBy']['userId']);
        $createdByUserName = $nodeData->getCreatedBy();
        $this->assertInternalType('string', $createdByUserName);
        $this->assertEquals($createdByUserName, $this->data['sys']['createdBy']['userName']);
        // get updated by
        $updatedByUserId = $nodeData->getUpdatedBy(true);
        $this->assertInternalType('string', $updatedByUserId);
        $this->assertEquals($updatedByUserId, $this->data['sys']['updatedBy']['userId']);
        $updatedByUserName = $nodeData->getUpdatedBy();
        $this->assertInternalType('string', $updatedByUserName);
        $this->assertEquals($updatedByUserName, $this->data['sys']['updatedBy']['userName']);
        // get authors
        $authors = $nodeData->getAuthors();
        $this->assertContainsOnly('string', $authors);
        foreach ($this->data['authors'] as $author) {
            $this->assertContains($author, $authors);
        }
        // get authors - not defined
        $authors = $emptyNodeData->getAuthors();
        $this->assertNull($authors);
        // get picture
        $pictureId = $nodeData->getPictureId();
        $this->assertInternalType('string', $pictureId);
        $this->assertEquals($pictureId, $this->data['picture']);
        // get picture - not defined
        $pictureId = $emptyNodeData->getPictureId();
        $this->assertNull($pictureId);
        // get section path
        $sectionPath = $nodeData->getSectionPath();
        $this->assertInternalType('string', $sectionPath);
        $this->assertEquals($sectionPath, $this->data['pubInfo']['sectionPath']);
        // get canonical
        $canonical = $nodeData->getCanonical();
        $this->assertInternalType('string', $canonical);
        $this->assertEquals($canonical, $this->data['pubInfo']['canonical']);
        // get canonical - not defined
        $canonical = $emptyNodeData->getCanonical();
        $this->assertNull($canonical);
        // get content
        $content = $nodeData->getContent();
        $this->assertInternalType('string', $content);
        // get content - not defined
        $content = $emptyNodeData->getContent();
        $this->assertNull($content);
    }

}