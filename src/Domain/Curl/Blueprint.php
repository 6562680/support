<?php

namespace Gzhegow\Support\Domain\Curl;

use Gzhegow\Support\IArr;
use Gzhegow\Support\INet;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Blueprint
 */
class Blueprint
{
    /**
     * @var IArr
     */
    protected $arr;
    /**
     * @var IFilter
     */
    protected $filter;
    /**
     * @var INet
     */
    protected $net;


    /**
     * @var Manager
     */
    protected $formatter;


    /**
     * @var array
     */
    protected $curlOptArrayInit = [];
    /**
     * @var array
     */
    protected $curlOptArray;



    /**
     * Constructor
     *
     * @param IArr             $arr
     * @param IFilter          $filter
     * @param INet             $net
     *
     * @param ManagerInterface $formatter
     *
     * @param array            $curlOptArray
     */
    public function __construct(
        IArr $arr,
        IFilter $filter,
        INet $net,

        ManagerInterface $formatter,

        array $curlOptArray = []
    )
    {
        $this->arr = $arr;
        $this->filter = $filter;
        $this->net = $net;

        $this->formatter = $formatter;

        $this->curlOptArrayInit = $curlOptArray;
        $this->curlOptArray = $this->curlOptArrayInit;
    }


    /**
     * @return static
     */
    public function resetOptArray()
    {
        $this->curlOptArray = $this->curlOptArrayInit;

        return $this;
    }


    /**
     * @param bool $verbose
     *
     * @return array
     */
    public function getOptArray(bool $verbose = false) : array
    {
        return $verbose
            ? $this->formatter->formatOptions($this->curlOptArray)
            : $this->curlOptArray;
    }


    /**
     * @param string $opt
     * @param mixed  $value
     *
     * @return static
     */
    public function setOpt(string $opt, $value)
    {
        if (null === ( $optCode = $this->formatter->curlOptCodeVal($opt) )) {
            throw new InvalidArgumentException('Invalid CURL option: ' . $opt);
        }

        $this->curlOptArray[ $optCode ] = $value;

        return $this;
    }

    /**
     * @param array $opts
     *
     * @return static
     */
    public function setOptArray(array $opts)
    {
        foreach ( $opts as $opt => $val ) {
            $this->setOpt($opt, $val);
        }

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
        return $this->request($this->net::METHOD_GET, $url, $data, $headers);
    }


    /**
     * @return static
     */
    public function clearOptArray()
    {
        $this->curlOptArray = [];

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
        return $this->request($this->net::METHOD_HEAD, $url, null, $headers);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function options(string $url, array $headers = null)
    {
        return $this->request($this->net::METHOD_OPTIONS, $url, null, $headers);
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
        return $this->request($this->net::METHOD_POST, $url, $data, $headers);
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
        return $this->request($this->net::METHOD_PATCH, $url, $data, $headers);
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
        return $this->request($this->net::METHOD_PUT, $url, $data, $headers);
    }

    /**
     * @param string     $url
     * @param null|array $headers
     *
     * @return resource|\CurlHandle
     */
    public function delete(string $url, array $headers = null)
    {
        return $this->request($this->net::METHOD_DELETE, $url, null, $headers);
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
        return $this->request($this->net::METHOD_PURGE, $url, $data, $headers);
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
        $httpMethod = $this->net->theHttpMethodVal($method);

        $headers = $headers ?? [];

        $isMethodOptions = ( $this->net::METHOD_OPTIONS === $httpMethod );
        $isMethodHead = ( $this->net::METHOD_HEAD === $httpMethod );
        $isMethodGet = ( $this->net::METHOD_GET === $httpMethod );

        $isNoData = 0
            || $isMethodOptions
            || $isMethodHead;
        $isNoBody = 0
            || $isMethodOptions
            || $isMethodHead
            || $isMethodGet;

        $curlOptArray = [];
        $curlOptArray[ CURLOPT_CUSTOMREQUEST ] = $httpMethod;

        if ($isMethodHead || $isMethodOptions) {
            $curlOptArray[ CURLOPT_HEADER ] = 1;
            $curlOptArray[ CURLOPT_NOBODY ] = 1;
        }

        $fields = [];
        $files = [];
        $body = '';
        if ($data) {
            if ($isNoData) {
                throw new RuntimeException(
                    'Unable to send data using method: ' . $httpMethod
                );
            }

            $flatten = [];
            if (is_array($data)) {
                foreach ( $this->arr->walk($data) as $fullpath => $value ) {
                    $flatten[] = [ $fullpath, $value ];
                }
            } elseif (null !== ( $fileObject = $this->filter->filterFileObject($data) )) {
                $flatten[] = [ [ 'file' ], $fileObject ];

            } elseif (null !== $this->filter->filterStrval($data)) {
                $body = strval($data);
            }

            foreach ( $flatten as [ $fullpath, $value ] ) {
                if (null !== $this->filter->filterStrval($value)) {
                    $this->arr->set($fields, $fullpath, strval($value));
                }

                if (null !== ( $fileObject = $this->filter->filterFileObject($value) )) {
                    $this->arr->set($files, $fullpath,
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
                    $headers[] = 'Content-ZType: multipart/form-data';

                    $key = implode(";\n", [
                        'raw',
                        'Content-ZType: text/plain',
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

            $curlOptArray[ CURLOPT_POSTFIELDS ] = $requestBody;
        }

        if ($headers) {
            $curlOptArray[ CURLOPT_HTTPHEADER ] = $headers;
        }

        $curlOptArray = $this->formatter->mergeOptions(
            $this->getOptArray(),
            $curlOptArray
        );

        $ch = curl_init($url);

        curl_setopt_array($ch, $curlOptArray);

        return $ch;
    }
}