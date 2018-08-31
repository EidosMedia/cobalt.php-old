<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Cobalt;
use Eidosmedia\Cobalt\Commons\ServiceInfo;
use Eidosmedia\Cobalt\Commons\PaginatedResult;
use Eidosmedia\Cobalt\Site\Site;
use Eidosmedia\Cobalt\Site\Sitemap;
use Eidosmedia\Cobalt\Site\NodeData;
use Eidosmedia\Cobalt\Site\ContentData;
use Eidosmedia\Cobalt\Site\Page;
use Eidosmedia\Cobalt\Site\SiteData;
use Eidosmedia\Cobalt\Site\SiteNode;

class SiteTest extends TestCase {

    private $discoveryUri = 'http://localhost:8480/discovery';
    private $siteName = 'test-site';
    private $siteTitle = 'Test Site';

    public function testGetSite() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $this->assertInstanceOf(Site::class, $service);
        $serviceInfo = $service->getInfo();
        $this->assertInstanceOf(ServiceInfo::class, $serviceInfo);
        $this->assertEquals($serviceInfo->getType(), 'SITE');
    }

    public function testGetSitemap() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $sitemap = $service->getSitemap($this->siteName);
        $this->assertInstanceOf(Sitemap::class, $sitemap);
        $root = $sitemap->getRoot();
        $this->assertInstanceOf(NodeData::class, $root);
        $this->assertEquals($root->getName(), $this->siteName);
        $this->assertEquals($root->getTitle(), $this->siteTitle);
    }

    public function testGetMenu() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $sitemap = $service->getSitemap($this->siteName);
        $root = $sitemap->getRoot();
        $menu = $sitemap->getMenu($root->getId());
        $this->assertContainsOnlyInstancesOf(NodeData::class, $menu);
        foreach ($menu as $node) {
            $this->assertEquals($node->getParentId(), $root->getId());
            // check also second level menus
            $submenu = $sitemap->getMenu($node);
            $this->assertContainsOnlyInstancesOf(NodeData::class, $submenu);
            foreach ($submenu as $subnode) {
                $this->assertEquals($subnode->getParentId(), $node->getId());
            }
        }
        // get menu by nodedata
        $menu = $sitemap->getMenu($root);
        $this->assertContainsOnlyInstancesOf(NodeData::class, $menu);
    }

    public function testGetNodesBySectionPath() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $paginatedResult = $service->getNodes($this->siteName, '/');
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $result = $paginatedResult->getResult();
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
    }

    public function testGetNodesBySection() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $sitemap = $service->getSitemap($this->siteName);
        $root = $sitemap->getRoot();
        $paginatedResult = $service->getNodes($this->siteName, $root);
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $result = $paginatedResult->getResult();
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
    }

    public function testGetNodesBySectionId() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $sitemap = $service->getSitemap($this->siteName);
        $root = $sitemap->getRoot();
        $paginatedResult = $service->getNodes($this->siteName, $root->getId());
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $result = $paginatedResult->getResult();
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
    }

    public function testGetNode() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $sitemap = $service->getSitemap($this->siteName);
        $root = $sitemap->getRoot();
        $node = $service->getNode($this->siteName, $root->getId());
        $this->assertInstanceOf(NodeData::class, $node);
        $this->assertEquals($node->getId(), $root->getId());
    }

    public function testGetPage() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $page = $service->getPage($this->siteName, '/');
        $this->assertInstanceOf(Page::class, $page);
        $contentData = $page->getModel();
        $this->assertInstanceOf(ContentData::class, $contentData);
        $this->assertEquals($contentData->getDataType(), 'node');
        $nodeData = $contentData->getNodeData();
        $this->assertInstanceOf(NodeData::class, $nodeData);
        $this->assertContainsOnlyInstancesOf(NodeData::class, $contentData->getNodes());
        $this->assertContainsOnly('string', $contentData->getChildren());
        $this->assertInternalType('int', $contentData->getTotalPages());
        $this->assertInternalType('int', $contentData->getPage());
        $siteData = $page->getSiteData();
        $this->assertInstanceOf(SiteData::class, $siteData);
        $this->assertEquals($siteData->getSiteName(), $this->siteName);
        $this->assertInternalType('string', $siteData->getViewStatus());
        $this->assertInternalType('string', $siteData->getRootId());
        $siteNode = $page->getSiteNode();
        $this->assertInstanceOf(SiteNode::class, $siteNode);
        $this->assertInternalType('string', $siteNode->getId());
        $this->assertEquals($siteNode->getName(), $this->siteName);
        $this->assertEquals($siteNode->getTitle(), $this->siteTitle);
        $this->assertInternalType('string', $siteNode->getDescription());
        $this->assertEquals($siteNode->getUri(), '/');
        $this->assertEquals($siteNode->getStatus(), 'ENABLED');
        $this->assertEquals($siteNode->getType(), 'site');
        $this->assertEquals($siteNode->getPath(), '/');
    }

    public function testGetPageByNodeData() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $sitemap = $service->getSitemap($this->siteName);
        $root = $sitemap->getRoot();
        $page = $service->getPage($this->siteName, $root);
        $this->assertInstanceOf(Page::class, $page);
    }

    public function testGetPageByNodeId() {
        $cobalt = new Cobalt($this->discoveryUri);
        $service = $cobalt->getSite();
        $sitemap = $service->getSitemap($this->siteName);
        $root = $sitemap->getRoot();
        $page = $service->getPage($this->siteName, $root->getId());
        $this->assertInstanceOf(Page::class, $page);
    }

}