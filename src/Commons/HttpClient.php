<?php

namespace Eidosmedia\Cobalt\Commons;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;

use Stringy\StaticStringy as S;
use Eidosmedia\Cobalt\Commons\Exceptions\HttpClientException;

class HttpClient {

    private $basePath;

    public function __construct($basePath) {
        $this->httpClient = new GuzzleHttpClient();
        $this->basePath = $basePath;
    }

    public function get($path, $query = null) {
        try {
            $options = [];
            if ($query != null) {
                $options['query'] = $query; 
            }
            $response = $this->httpClient->request('GET', $this->buildUrl($path), $options);
            // FIXME: check response
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $ex) {
            throw new HttpClientException($ex->getMessage());
        }
    }

    private function buildUrl($path) {
        if (S::endsWith($this->basePath, '/')) {
            if (S::startsWith($path, '/')) {
                return S::slice($this->basePath, 0, -1) . $path;
            } else {
                return $this->basePath . $path;
            }
        } else {
            if (S::startsWith($path, '/')) {
                return $this->basePath . $path;
            } else {
                return $this->basePath . '/' . $path;
            }
        }
    }

}