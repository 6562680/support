<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\XPhp;
use Gzhegow\Support\IPhp;
use Gzhegow\Support\XCurl;
use Gzhegow\Support\ICurl;


class CurlTest extends AbstractTestCase
{
    protected function getCurl() : ICurl
    {
        return XCurl::getInstance();
    }

    protected function getPhp() : IPhp
    {
        return XPhp::getInstance();
    }


    /**
     * @return bool
     */
    protected function isOnline() : bool
    {
        $curl = $this->getCurl();

        $ch = $curl->head('https://my-json-server.typicode.com/typicode/demo/posts');

        curl_exec($ch);

        if (! $result = (0 === curl_errno($ch))) {
            dump(curl_error($ch));
        }

        return $result;
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
        $responseCode = $curl->curlinfoOpt($ch, CURLINFO_HTTP_CODE);

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
            'Content-Type' => 'application/json',
        ]);

        $responseJson = json_decode(
            '{"id":4}',
            true
        );

        $response = curl_exec($ch);
        $responseCode = $curl->curlinfoOpt($ch, CURLINFO_HTTP_CODE);

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
            'Content-Type' => 'application/json',
        ]);

        $responseJson = json_decode('{"id":1}', true);

        $response = curl_exec($ch);
        $responseCode = $curl->curlinfoOpt($ch, CURLINFO_HTTP_CODE);

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
            'Content-Type' => 'application/json',
        ]);

        $responseJson = json_decode('{"id":1,"title":"Post 1"}', true);

        $response = curl_exec($ch);
        $responseCode = $curl->curlinfoOpt($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $this->assertEquals($responseJson, json_decode($response, true));
        $this->assertEquals(200, $responseCode);
    }

    public function testDelete()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $ch = $curl->delete('https://my-json-server.typicode.com/typicode/demo/posts/1', [
            'Content-Type' => 'application/json',
        ]);

        $response = curl_exec($ch);
        $responseCode = $curl->curlinfoOpt($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $this->assertEquals('{}', $response);
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
            return json_decode($result, true);
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
        $php = $this->getPhp();

        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        $results = [];

        $queue = $hh;
        while ( $slice = array_slice($queue, 0, 2, true) ) {
            $queue = array_diff_key($queue, $slice);

            $results += $curl->execMulti($slice);

            $php->sleep(1);
        }

        $responses = array_map(function ($result) {
            return json_decode($result, true);
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

        $h1 = $curl->get(
            'https://my-json-server.typicode.com/typicode/demo/posts',
            [ 'array' ],
            [ 'Accept' => 'application/json' ]
        );
        $h2 = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts',
            [ 'dict' => 'text' ],
            [ 'Accept' => 'application/json' ]
        );

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        $response1 = curl_exec($h1);
        $response2 = curl_exec($h2);

        $responseCode1 = $curl->curlinfoOpt($h1, CURLINFO_HTTP_CODE);
        $responseCode2 = $curl->curlinfoOpt($h2, CURLINFO_HTTP_CODE);

        curl_close($h1);
        curl_close($h2);

        $this->assertEquals($responseJson, json_decode($response1, true));
        $this->assertEquals($responseJson, json_decode($response2, true));

        $this->assertEquals(200, $responseCode1);
        $this->assertEquals(200, $responseCode2);
    }

    public function testGetWithBlueprint()
    {
        $this->assertTrue($this->isOnline(), 'Connection timeout');

        $curl = $this->getCurl();

        $cbp = $curl->getCurlBlueprint();
        $cbp->addCurloptArray([
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36',
        ]);

        $h = $curl->get(
            'https://my-json-server.typicode.com/typicode/demo/posts',
            [ 'array' ],
            [ 'Accept' => 'application/json' ]
        );

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        $response = curl_exec($h);
        $responseCode = $curl->curlinfoOpt($h, CURLINFO_HTTP_CODE);
        curl_close($h);

        $this->assertEquals($responseJson, json_decode($response, true));

        $this->assertEquals(200, $responseCode);
    }


    /**
     * @var string
     */
    protected static $isOnline;
}