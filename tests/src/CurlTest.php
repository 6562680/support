<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\ZCurl;
use Gzhegow\Support\ICurl;


class CurlTest extends AbstractTestCase
{
    protected function getCurl() : ICurl
    {
        return ZCurl::getInstance();
    }

    /**
     * @return bool
     */
    protected function isOnline() : bool
    {
        if (! isset(static::$isOnline)) {
            $curl = $this->getCurl();

            $ch = $curl->head('https://my-json-server.typicode.com/typicode/demo/posts');

            curl_exec($ch);

            $errno = curl_errno($ch);

            static::$isOnline = ! $errno;
        }

        return static::$isOnline;
    }

    public function testGet()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $ch = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        $response = curl_exec($ch);
        $responseCode = $curl->curlInfoOpt($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $this->assertEquals($responseJson, json_decode($response, true));
        $this->assertEquals(200, $responseCode);
    }

    public function testPost()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $json = '{"id":4,"title":"Post 4"}';
        $ch = $curl->post('https://my-json-server.typicode.com/typicode/demo/posts', $json, [
            'Content-ZType' => 'application/json',
        ]);

        $responseJson = json_decode(
            '{"id":4}',
            true
        );

        $response = curl_exec($ch);
        $responseCode = $curl->curlInfoOpt($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $this->assertEquals($responseJson, json_decode($response, true));
        $this->assertEquals(201, $responseCode);
    }

    public function testPut()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $json = '{"title":"Post 4"}';
        $ch = $curl->put('https://my-json-server.typicode.com/typicode/demo/posts/1', $json, [
            'Content-ZType' => 'application/json',
        ]);

        $responseJson = json_decode('{"id":1}', true);

        $response = curl_exec($ch);
        $responseCode = $curl->curlInfoOpt($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $this->assertEquals($responseJson, json_decode($response, true));
        $this->assertEquals(200, $responseCode);
    }

    public function testPatch()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $json = '{"title":"Post 1"}';
        $ch = $curl->patch('https://my-json-server.typicode.com/typicode/demo/posts/1', $json, [
            'Content-ZType' => 'application/json',
        ]);

        $responseJson = json_decode('{"id":1,"title":"Post 1"}', true);

        $response = curl_exec($ch);
        $responseCode = $curl->curlInfoOpt($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $this->assertEquals($responseJson, json_decode($response, true));
        $this->assertEquals(200, $responseCode);
    }

    public function testDelete()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $ch = $curl->delete('https://my-json-server.typicode.com/typicode/demo/posts/1', [
            'Content-ZType' => 'application/json',
        ]);

        $responseJson = json_decode('{}', true);

        $response = curl_exec($ch);
        $responseCode = $curl->curlInfoOpt($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $this->assertEquals($responseJson, json_decode($response, true));
        $this->assertEquals(200, $responseCode);
    }

    public function testMulti()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        $results = $curl->execMulti($hh);

        $responses = array_map(function ($result) {
            return json_decode($result->content, true);
        }, $results);
        $responseKeys = array_keys($responses);
        $responseCodes = array_map(function ($ch) {
            return curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        }, $hh);

        $this->assertEquals(
            array_combine($responseKeys, [
                $responseJson,
                $responseJson,
                $responseJson,
            ]),
            $responses
        );
        $this->assertEquals([ 200, 200, 200 ], $responseCodes);
    }

    public function testBatch()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        $results = $curl->execBatch(2, 1, $hh);

        $responses = array_map(function ($result) {
            return json_decode($result->content, true);
        }, $results);
        $responseKeys = array_keys($responses);
        $responseCodes = array_map(function ($ch) {
            return curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        }, $hh);

        $this->assertEquals(
            array_combine($responseKeys, [
                $responseJson,
                $responseJson,
                $responseJson,
            ]),
            $responses
        );
        $this->assertEquals([ 200, 200, 200 ], $responseCodes);
    }

    public function testGetWithQueryAndHeaders()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $ch1 = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts', [ 'array' ], [
            'Accept' => 'application/json',
        ]);
        $ch2 = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts', [ 'dict' => 'text' ], [
            'Accept' => 'application/json',
        ]);

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        $response1 = curl_exec($ch1);
        $response2 = curl_exec($ch2);

        $responseCode1 = $curl->curlInfoOpt($ch1, CURLINFO_HTTP_CODE);
        $responseCode2 = $curl->curlInfoOpt($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch1);
        curl_close($ch2);

        $this->assertEquals($responseJson, json_decode($response1, true));
        $this->assertEquals($responseJson, json_decode($response2, true));

        $this->assertEquals(200, $responseCode1);
        $this->assertEquals(200, $responseCode2);
    }

    /**
     * @var string
     */
    protected static $isOnline;
}