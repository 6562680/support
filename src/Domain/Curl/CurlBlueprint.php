<?php

namespace Gzhegow\Support\Domain\Curl;

use Gzhegow\Support\Traits\Load\FsLoadTrait;
use Gzhegow\Support\Traits\Load\ArrLoadTrait;
use Gzhegow\Support\Traits\Load\NetLoadTrait;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Traits\Load\Curl\CurloptManagerLoadTrait;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * CurlBlueprint
 */
class CurlBlueprint
{
    use ArrLoadTrait;
    use FsLoadTrait;
    use NetLoadTrait;
    use StrLoadTrait;

    use CurloptManagerLoadTrait;


    /**
     * @var array
     */
    protected $curloptArray = [];
    /**
     * @var array
     */
    protected $curloptArrayDefault = [];


    /**
     * Constructor
     *
     * @param null|array $curloptArrayDefault
     */
    public function __construct(
        array $curloptArrayDefault = null
    )
    {
        $curloptArrayDefault = $curloptArrayDefault ?? [];

        $this->curloptArrayDefault = $curloptArrayDefault;
        $this->curloptArray = $this->curloptArrayDefault;
    }


    /**
     * @return static
     */
    public function resetCurloptArray()
    {
        $this->curloptArray = $this->curloptArrayDefault;

        return $this;
    }


    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function get(string $url, $data = null, array $headers = null)
    {
        return $this->request($this->getNet()::METHOD_GET, $url, $data, $headers);
    }


    /**
     * @param bool $verbose
     *
     * @return array
     */
    public function getCurloptArray(bool $verbose = null) : array
    {
        $verbose = $verbose ?? false;

        return $verbose
            ? $this->getCurloptManager()->formatCurloptArray($this->curloptArray)
            : $this->curloptArray;
    }


    /**
     * @param int|string $curlopt
     * @param mixed      $value
     *
     * @return static
     */
    public function setCurlopt($curlopt, $value)
    {
        if (null === ( $optCode = $this->getCurloptManager()->curloptCodeVal($curlopt) )) {
            throw new InvalidArgumentException('Invalid CURL option: ' . $curlopt);
        }

        $this->curloptArray[ $optCode ] = $value;

        return $this;
    }


    /**
     * @param array $curloptArray
     *
     * @return static
     */
    public function setCurloptArray(array $curloptArray)
    {
        $this->curloptArray = [];

        $this->addCurloptArray($curloptArray);

        return $this;
    }

    /**
     * @param array $curloptArray
     *
     * @return static
     */
    public function addCurloptArray(array $curloptArray)
    {
        foreach ( $curloptArray as $curlopt => $val ) {
            $this->setCurlopt($curlopt, $val);
        }

        return $this;
    }


    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function head(string $url, array $headers = null)
    {
        return $this->request($this->getNet()::METHOD_HEAD, $url, null, $headers);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function options(string $url, array $headers = null)
    {
        return $this->request($this->getNet()::METHOD_OPTIONS, $url, null, $headers);
    }


    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function post(string $url, $data = null, array $headers = null)
    {
        return $this->request($this->getNet()::METHOD_POST, $url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function patch(string $url, $data = null, array $headers = null)
    {
        return $this->request($this->getNet()::METHOD_PATCH, $url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function put(string $url, $data = null, array $headers = null)
    {
        return $this->request($this->getNet()::METHOD_PUT, $url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function delete(string $url, array $headers = null)
    {
        return $this->request($this->getNet()::METHOD_DELETE, $url, null, $headers);
    }


    /**
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function purge(string $url, $data = null, array $headers = null)
    {
        return $this->request($this->getNet()::METHOD_PURGE, $url, $data, $headers);
    }


    /**
     * @param string     $method
     * @param string     $url
     * @param mixed      $data
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function request(string $method, string $url, $data = null, array $headers = null)
    {
        $theNet = $this->getNet();

        $httpMethod = $theNet->theHttpMethodVal($method);

        $headers = $headers ?? [];

        $isMethodOptions = ( $theNet::METHOD_OPTIONS === $httpMethod );
        $isMethodHead = ( $theNet::METHOD_HEAD === $httpMethod );
        $isMethodGet = ( $theNet::METHOD_GET === $httpMethod );

        $isNoData = 0
            || $isMethodOptions
            || $isMethodHead;
        $isNoBody = 0
            || $isMethodOptions
            || $isMethodHead
            || $isMethodGet;

        $curloptArray = [];
        $curloptArray[ CURLOPT_CUSTOMREQUEST ] = $httpMethod;

        if ($isMethodHead || $isMethodOptions) {
            $curloptArray[ CURLOPT_HEADER ] = 1;
            $curloptArray[ CURLOPT_NOBODY ] = 1;
        }

        $fields = [];
        $files = [];
        $body = '';
        if ($data) {
            $theArr = $this->getArr();
            $theFs = $this->getFs();
            $theStr = $this->getStr();

            if ($isNoData) {
                throw new RuntimeException(
                    'Unable to send data using method: ' . $httpMethod
                );
            }

            $flatten = [];
            if (is_array($data)) {
                foreach ( $theArr->walk($data) as $fullpath => $value ) {
                    $flatten[] = [ $fullpath, $value ];
                }
            } elseif (null !== ( $fileObject = $theFs->filterFileObject($data) )) {
                $flatten[] = [ [ 'file' ], $fileObject ];

            } elseif (null !== $theStr->filterStrval($data)) {
                $body = strval($data);
            }

            foreach ( $flatten as [ $fullpath, $value ] ) {
                if (null !== $theStr->filterStrval($value)) {
                    $theArr->set($fields, $fullpath, strval($value));
                }

                if (null !== ( $fileObject = $theFs->filterFileObject($value) )) {
                    $theArr->set($files, $fullpath,
                        curl_file_create($fileObject->getRealPath(),
                            mime_content_type($fileObject->getRealPath())
                        )
                    );
                }
            }

            if ($isNoBody && $files) {
                throw new InvalidArgumentException(
                    'Unable to send files using method: ' . $httpMethod
                );
            }

            if ($body) {
                if ($isNoBody) {
                    throw new InvalidArgumentException(
                        'Unable to send raw body using method: ' . $httpMethod
                    );
                }

                if ($fields) {
                    $headers[] = 'Content-Type: multipart/form-data';

                    $key = implode(";\n", [
                        'raw',
                        'Content-Type: text/plain',
                        'Content-Disposition: form-data',
                    ]);

                    $fields[ $key ] = $body;
                }
            }

            $requestBody = $isMethodGet
                ? http_build_query($fields)
                : ( is_array($fields)
                    ? array_replace_recursive($fields, $files)
                    : $body
                );

            $curloptArray[ CURLOPT_POSTFIELDS ] = $requestBody;
        }

        if ($headers) {
            $curloptArray[ CURLOPT_HTTPHEADER ] = $headers;
        }

        $curloptArray = $this->getCurloptManager()->mergeCurloptArrays(
            $this->getCurloptArray(),
            $curloptArray
        );

        $ch = curl_init($url);

        curl_setopt_array($ch, $curloptArray);

        return $ch;
    }
}