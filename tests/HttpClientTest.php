<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Commons\HttpClient;
use Eidosmedia\Cobalt\Commons\Exceptions\HttpClientException;

class HttpClientTest extends TestCase {

    public function testHttpClientBuildUrl1() {
        $httpClient = new HttpClient('http://localhost:8480/api/');
        $response = $httpClient->get('/');
        $this->assertEquals($response['state'], 'RUNNING');
    }

    public function testHttpClientBuildUrl2() {
        $httpClient = new HttpClient('http://localhost:8480/api');
        $response = $httpClient->get('');
        $this->assertEquals($response['state'], 'RUNNING');
    }

    public function testHttpClientBuildUrl3() {
        $httpClient = new HttpClient('http://localhost:8480/api');
        $response = $httpClient->get('/');
        $this->assertEquals($response['state'], 'RUNNING');
    }

    public function testHttpClientBuildUrl4() {
        $httpClient = new HttpClient('http://localhost:8480/api/');
        $response = $httpClient->get('');
        $this->assertEquals($response['state'], 'RUNNING');
    }

    public function testHttpClientException() {
        $this->expectException(HttpClientException::class);
        $httpClient = new HttpClient('http://invalid-hostname/');
        $httpClient->get('/');
    }

}