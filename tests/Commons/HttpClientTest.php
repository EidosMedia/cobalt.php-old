<?php

namespace Eidosmedia\Tests\Cobalt;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Commons\HttpClient;
use Eidosmedia\Cobalt\Commons\Exceptions\HttpClientException;

class HttpClientTest extends TestCase {

    public function write($msg) {
        $fh = fopen(date('Ymd') . '.log', 'a+') or die("Unable to open file");
        fwrite($fh, date('Y-m-d H:i:s') . ' ' . $msg . "\n\n");
        fclose($fh);
    }

    public function testHttpClientBuildUrl1() {
        //$httpClient = new HttpClient('http://localhost:8480/api/');
        $httpClient = new HttpClient('https://demo.eidosmedia.io/api/');
        $response = $httpClient->get('/');
        $this->write('url1 ' . json_encode($response));
        $this->assertEquals($response['state'], 'RUNNING');
    }

    public function testHttpClientBuildUrl2() {
        $httpClient = new HttpClient('https://demo.eidosmedia.io/api');
        $response = $httpClient->get('');
        $this->write('url2 ' . json_encode($response));
        $this->assertEquals($response['state'], 'RUNNING');
    }

    public function testHttpClientBuildUrl3() {
        $httpClient = new HttpClient('https://demo.eidosmedia.io/api');
        $response = $httpClient->get('/');
        $this->write('url3 ' . json_encode($response));
        $this->assertEquals($response['state'], 'RUNNING');
    }

    public function testHttpClientBuildUrl4() {
        $httpClient = new HttpClient('https://demo.eidosmedia.io/api/');
        $response = $httpClient->get('');
        $this->write('url4 ' . json_encode($response));
        $this->assertEquals($response['state'], 'RUNNING');
    }

    public function testHttpClientException() {
        $this->expectException(HttpClientException::class);
        $httpClient = new HttpClient('http://invalid-hostname/');
        $httpClient->get('/');
    }

}