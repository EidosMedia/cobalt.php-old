<?php

namespace Eidosmedia\Cobalt\Site;

use Stringy\StaticStringy as S;
use Eidosmedia\Cobalt\Commons\Service;
use Eidosmedia\Cobalt\Commons\PaginatedResult;

class Site extends Service {

    public function __construct($serviceInfo) {
        parent::__construct($serviceInfo);
    }

    public function getSitemap($siteName) {
        $response = $this->getHttpClient()->get('/api/site', [
            'emk.site' => $siteName
        ]);
        return new Sitemap($response);
    }

    public function getNodes($siteName, $section = '/', $recursive = false, $offset = 0, $limit = 20) {
        $query = [
            'emk.site' => $siteName,
            'recursive' => $recursive,
            'offset' => $offset,
            'limit' => $limit
        ];
        if ($section instanceof NodeData) {
            $query['sectionId'] = $section->getId();
        } else if (S::startsWith($section, '/')) {
            $query['section'] = $section;
        } else {
            $query['sectionId'] = $section;
        }
        $response = $this->getHttpClient()->get('/api/nodes', $query);
        $nodes = [];
        foreach ($response['result'] as $resultItem) {
            $nodes[] = new NodeData($resultItem);
        }
        return new PaginatedResult($nodes, $response['count'], $response['offset'], $response['limit']);
    }

    public function getNode($siteName, $id) {
        $response = $this->getHttpClient()->get('/api/nodes/' . $id, [
            'emk.site' => $siteName
        ]);
        return new NodeData($response);
    }

}