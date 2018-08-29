<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\Service;

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

}