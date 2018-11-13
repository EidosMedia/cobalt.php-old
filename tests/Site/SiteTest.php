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

    //private $discoveryUri = 'http://localhost:8480/discovery';
    private $discoveryUri = 'https://demo.eidosmedia.io/discovery';
    //private $siteName = 'test-site';
    private $siteName = 'express-website';

    public function write($msg) {
        $fh = fopen(date('Ymd') . '.log', 'a+') or die("Unable to open file");
        fwrite($fh, date('Y-m-d H:i:s') . ' ' . $msg . "\n\n");
        fclose($fh);
    }

    public function test() {
        $cobalt = new Cobalt($this->discoveryUri);
        // get site
        $service = $cobalt->getSite();
        $this->write('service ' . json_encode($service));
        $this->assertInstanceOf(Site::class, $service);
        // get service info
        $serviceInfo = $service->getInfo();
        $this->write('serviceInfo ' . json_encode($serviceInfo));
        $this->assertInstanceOf(ServiceInfo::class, $serviceInfo);
        $this->assertEquals($serviceInfo->getType(), 'SITE');
        // get sitemap
        $sitemap = $service->getSitemap($this->siteName);
        $this->write('sitemap ' . json_encode($sitemap));
        $this->assertInstanceOf(Sitemap::class, $sitemap);
        $root = $sitemap->getRoot();
        $this->write('root ' . json_encode($root));

        // get nodes by section node data
        $paginatedResult = $service->getNodes($this->siteName, $root);
        $this->write('paginatedResult ' . json_encode($paginatedResult));
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        
        $result = $paginatedResult->getResult();
        $this->write('result ' . json_encode($result));
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
        
        // get nodes by section path
        $paginatedResult = $service->getNodes($this->siteName, '/');
        $this->write('paginatedResult ' . json_encode($paginatedResult));
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $result = $paginatedResult->getResult();
        $this->write('result ' . json_encode($result));
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
        // get nodes by section id
        $paginatedResult = $service->getNodes($this->siteName, $root->getId());
        $this->write('paginatedResult ' . json_encode($paginatedResult));
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $result = $paginatedResult->getResult();
        $this->write('result ' . json_encode($result));
        $this->assertContainsOnlyInstancesOf(NodeData::class, $result);
        // get node
        $node = $service->getNode($this->siteName, $root->getId());
        $this->write('node ' . json_encode($node));
        $this->assertInstanceOf(NodeData::class, $node);
        $this->assertEquals($node->getId(), $root->getId());
        // get page by url
        $page = $service->getPage($this->siteName, '/');
        $this->write('page ' . json_encode($page));
        $this->assertInstanceOf(Page::class, $page);
        // get page by node data
        $page = $service->getPage($this->siteName, $root);
        $this->write('page1 ' . json_encode($page));
        $this->assertInstanceOf(Page::class, $page);
        // get page by id
        $page = $service->getPage($this->siteName, $root->getId());
        $this->write('page2 ' . json_encode($page));
        $this->assertInstanceOf(Page::class, $page);
    }

}