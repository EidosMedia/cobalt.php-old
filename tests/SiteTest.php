<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Cobalt;
use Eidosmedia\Cobalt\Commons\ServiceInfo;
use Eidosmedia\Cobalt\Commons\PaginatedResult;
use Eidosmedia\Cobalt\Site\Site;
use Eidosmedia\Cobalt\Site\Sitemap;
use Eidosmedia\Cobalt\Site\NodeData;

class SiteTest extends TestCase {

    private $discoveryUri = 'http://localhost:8480/discovery';
    private $siteName = 'test-site';
    private $siteTitle = 'test site';

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

}