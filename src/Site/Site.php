<?php

namespace Eidosmedia\Cobalt\Site;

use Stringy\StaticStringy as S;
use Eidosmedia\Cobalt\Commons\Service;
use Eidosmedia\Cobalt\Commons\PaginatedResult;

/**
 * Site service
 * 
 * @example
 * // build site service based on the discovery information <br />
 * $discoveryUri = "http://cobalt-endpoint/discovery"; <br />
 * $cobalt = new \Eidosmedia\Cobalt\Cobalt($discoveryUri); <br />
 * $siteService = $cobalt->getSite(); <br />
 * 
 * @example
 * // instantiate a site service from a service info <br />
 * $siteUri = "http://cobalt-endpoint"; <br />
 * $siteServiceInfo = new \Eidosmedia\Cobalt\Commons\ServiceInfo("SITE", $siteUri); <br />
 * $siteService = new \Eidosmedia\Cobalt\Site\Site($siteServiceInfo); <br />
 */
class Site extends Service {

    /**
     * Site service constructor
     * 
     * Instantiate a new site service, given its service info
     * 
     * @param ServiceInfo $serviceInfo the site service info
     */
    public function __construct($serviceInfo) {
        parent::__construct($serviceInfo);
    }

    /**
     * Sitemap of a given site
     * 
     * Method to retrieve the sitemap of a given site.
     * 
     * It calls the _/api/site_ resource.
     * 
     * @param string $siteName the site name
     * @return Sitemap the sitemap of the site
     */
    public function getSitemap($siteName) {
        $response = $this->getHttpClient()->get('/api/site', [
            'emk.site' => $siteName
        ]);
        return new Sitemap($response);
    }

    /**
     * List of nodes
     * 
     * Method to retrieve a list of nodes for a given site and section path.
     * 
     * It calls the _/api/nodes_ resource.
     * 
     * @param string $siteName the site name
     * @param string $section the section path
     * @param boolean $recursive if to consider also the subsections
     * @param int $offset the offset of the pagination
     * @param int $limit the size of a page for the pagination
     * @return PaginatedResult the list of NodeData mathing the given parameters 
     */
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

    /**
     * Node by id
     * 
     * Method to get a single node by its id for a given site.
     * 
     * It calls the _/api/nodes/{id}_ resource.
     * 
     * @param string $siteName the site name
     * @param string $id the node id
     * @return NodeData the node data for the given parameters
     */
    public function getNode($siteName, $id) {
        $response = $this->getHttpClient()->get('/api/nodes/' . $id, [
            'emk.site' => $siteName
        ]);
        return new NodeData($response);
    }

    /**
     * Page by id or path
     * 
     * Method to get a page by its path or id for a given site.
     * 
     * It calls the _/api/pages_ resource.
     * 
     * @param string $siteName the site name
     * @param $nodeOrIdOrPath it can be a node as a NodeDate, or its id as a string, or its path as a string
     * @return Page the page for the given parameters
     */
    public function getPage($siteName, $nodeOrIdOrPath) {
        $query = [
            'emk.site' => $siteName,
            'urlsAbsolute' => 'true'
        ];
        if ($nodeOrIdOrPath instanceof NodeData) {
            $api = '/api/pages/' . $nodeOrIdOrPath->getId();
        } else if (S::startsWith($nodeOrIdOrPath, '/')) {
            $query['url'] = $nodeOrIdOrPath;
            $api = '/api/pages';
        } else {
            $api = '/api/pages/' . $nodeOrIdOrPath;
        }
        $response = $this->getHttpClient()->get($api, $query);
        return new Page($response);
    }

}