<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Cobalt;
use Eidosmedia\Cobalt\Commons\ServiceInfo;
use Eidosmedia\Cobalt\Commons\PaginatedResult;
use Eidosmedia\Cobalt\Site\Site;
use Eidosmedia\Cobalt\Site\Sitemap;
use Eidosmedia\Cobalt\Site\NodeData;
use Eidosmedia\Cobalt\Site\Page;

class SiteTest extends TestCase {

    private $discoveryUri = 'http://localhost:8480/discovery';
    private $siteName = 'test-site';

    public function test() {
        $cobalt = new Cobalt($this->discoveryUri);
        // get site
        $service = $cobalt->getSite();
        $this->assertInstanceOf(Site::class, $service);
        // get service info
        $serviceInfo = $service->getInfo();
        $this->assertInstanceOf(ServiceInfo::class, $serviceInfo);
        $this->assertEquals($serviceInfo->getType(), 'SITE');
        // get sitemap
        $sitemap = $service->getSitemap($this->siteName);
        $this->assertInstanceOf(Sitemap::class, $sitemap);
        $root = $sitemap->getRoot();
        // get nodes by section node data
        $paginatedResult = $service->getNodes($this->siteName, $root);
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $result = $paginatedResult->getResult();
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
        // get nodes by section path
        $paginatedResult = $service->getNodes($this->siteName, '/');
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $result = $paginatedResult->getResult();
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
        // get nodes by section id
        $paginatedResult = $service->getNodes($this->siteName, $root->getId());
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $result = $paginatedResult->getResult();
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
        // get node
        $node = $service->getNode($this->siteName, $root->getId());
        $this->assertInstanceOf(NodeData::class, $node);
        $this->assertEquals($node->getId(), $root->getId());
        // get page by url
        $page = $service->getPage($this->siteName, '/');
        $this->assertInstanceOf(Page::class, $page);
        // get page by node data
        $page = $service->getPage($this->siteName, $root);
        $this->assertInstanceOf(Page::class, $page);
        // get page by id
        $page = $service->getPage($this->siteName, $root->getId());
        $this->assertInstanceOf(Page::class, $page);
    }

}