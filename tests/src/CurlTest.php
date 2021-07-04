<?php

namespace Gzhegow\Support\Tests;

use Gzhegow\Support\Curl;
use Gzhegow\Support\Domain\SupportFactory;


class CurlTest extends AbstractTestCase
{
    protected function getCurl() : Curl
    {
        return SupportFactory::getInstance()->newCurl();
    }


    public function testGet()
    {
        if ('pong' !== $this->ping()) {
            $this->assertTrue(false, 'Connection timeout');

            return;
        }

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
        if ('pong' !== $this->ping()) {
            $this->assertTrue(false, 'Connection timeout');

            return;
        }

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
        $responseCode = $curl->curlInfoOpt($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $this->assertEquals($responseJson, json_decode($response, true));
        $this->assertEquals(201, $responseCode);
    }

    public function testPut()
    {
        if ('pong' !== $this->ping()) {
            $this->assertTrue(false, 'Connection timeout');

            return;
        }

        $curl = $this->getCurl();

        $json = '{"title":"Post 4"}';
        $ch = $curl->put('https://my-json-server.typicode.com/typicode/demo/posts/1', $json, [
            'Content-Type' => 'application/json',
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
        if ('pong' !== $this->ping()) {
            $this->assertTrue(false, 'Connection timeout');

            return;
        }

        $curl = $this->getCurl();

        $json = '{"title":"Post 1"}';
        $ch = $curl->patch('https://my-json-server.typicode.com/typicode/demo/posts/1', $json, [
            'Content-Type' => 'application/json',
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
        if ('pong' !== $this->ping()) {
            $this->assertTrue(false, 'Connection timeout');

            return;
        }

        $curl = $this->getCurl();

        $ch = $curl->delete('https://my-json-server.typicode.com/typicode/demo/posts/1', [
            'Content-Type' => 'application/json',
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
        if ('pong' !== $this->ping()) {
            $this->assertTrue(false, 'Connection timeout');

            return;
        }

        $curl = $this->getCurl();

        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        [ $responses ] = $curl->multi($hh);

        $responses = array_map(function ($response) {
            return json_decode($response, true);
        }, $responses);
        $responseCodes = array_map(function ($ch) {
            return curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        }, $hh);

        $this->assertEquals([ $responseJson, $responseJson, $responseJson ], $responses);
        $this->assertEquals([ 200, 200, 200 ], $responseCodes);
    }

    public function testBatch()
    {
        if ('pong' !== $this->ping()) {
            $this->assertTrue(false, 'Connection timeout');

            return;
        }

        $curl = $this->getCurl();

        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
        $hh[] = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');

        $responseJson = json_decode(
            '[{"id":1,"title":"Post 1"},{"id":2,"title":"Post 2"},{"id":3,"title":"Post 3"}]',
            true
        );

        [ $responses ] = $curl->batch(2, 1, $hh);

        $responses = array_map(function ($response) {
            return json_decode($response, true);
        }, $responses);

        $responseCodes = array_map(function ($ch) {
            return curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        }, $hh);

        $this->assertEquals([ $responseJson, $responseJson, $responseJson ], $responses);
        $this->assertEquals([ 200, 200, 200 ], $responseCodes);
    }


    /**
     * @return null|string
     */
    protected function ping() : string
    {
        if (! isset(static::$ping)) {
            $curl = $this->getCurl();

            $ch = $curl->get('https://my-json-server.typicode.com/typicode/demo/posts');
            curl_exec($ch);

            $errno = curl_errno($ch);

            static::$ping = ! $errno ? 'pong' : '';
        }

        return static::$ping;
    }


    /**
     * @var string
     */
    protected static $ping;
}
