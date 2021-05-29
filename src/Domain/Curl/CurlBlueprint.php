<?php

namespace Gzhegow\Support\Domain\Curl;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * CurlBlueprint
 */
class CurlBlueprint
{
    /**
     * @var Arr
     */
    protected $arr;
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CurlFormatter
     */
    protected $formatter;


    /**
     * @var array
     */
    protected $curlOptArray;
    /**
     * @var array
     */
    protected $curlOptArrayInit = [];


    /**
     * Constructor
     *
     * @param Arr           $arr
     * @param Filter        $filter
     * @param CurlFormatter $formatter
     *
     * @param array         $curlOptArray
     */
    public function __construct(
        Arr $arr,
        Filter $filter,

        CurlFormatter $formatter,

        array $curlOptArray = []
    )
    {
        $this->arr = $arr;
        $this->filter = $filter;

        $this->formatter = $formatter;

        $this->curlOptArrayInit = $curlOptArray;
        $this->curlOptArray = $this->curlOptArrayInit;
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
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function get(string $url, $data = null, array $headers = [])
    {
        return $this->request(CurlFormatter::METHOD_GET, $url, $data, $headers);
    }


    /**
     * @param string $opt
     * @param mixed  $value
     *
     * @return static
     */
    public function setOpt(string $opt, $value)
    {
        if (null === ( $optCode = $this->formatter->detectOptCode($opt) )) {
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
     * @return static
     */
    public function clearOptArray()
    {
        $this->curlOptArray = [];

        return $this;
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
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function head(string $url, array $headers = [])
    {
        return $this->request(CurlFormatter::METHOD_HEAD, $url, null, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function options(string $url, array $headers = [])
    {
        return $this->request(CurlFormatter::METHOD_OPTIONS, $url, null, $headers);
    }


    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function post(string $url, $data = null, array $headers = [])
    {
        return $this->request(CurlFormatter::METHOD_POST, $url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function patch(string $url, $data = null, array $headers = [])
    {
        return $this->request(CurlFormatter::METHOD_PATCH, $url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function put(string $url, $data = null, array $headers = [])
    {
        return $this->request(CurlFormatter::METHOD_PUT, $url, $data, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function delete(string $url, array $headers = [])
    {
        return $this->request(CurlFormatter::METHOD_DELETE, $url, null, $headers);
    }


    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function purge(string $url, $data = null, array $headers = [])
    {
        return $this->request(CurlFormatter::METHOD_PURGE, $url, $data, $headers);
    }


    /**
     * @param string $method
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource|\CurlHandle
     */
    public function request(string $method, string $url, $data = null, array $headers = [])
    {
        $httpMethod = $this->formatter->detectHttpMethod($method);

        $isMethodDelete = ( CurlFormatter::METHOD_DELETE === $httpMethod );
        $isMethodGet = ( CurlFormatter::METHOD_GET === $httpMethod );
        $isMethodHead = ( CurlFormatter::METHOD_HEAD === $httpMethod );
        $isMethodOptions = ( CurlFormatter::METHOD_OPTIONS === $httpMethod );

        $isNoData = 0
            || $isMethodDelete
            || $isMethodHead
            || $isMethodOptions;
        $isNoBody = 0
            || $isNoData
            || $isMethodGet;
        $isNoFiles = 0
            || $isNoBody;

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
            } elseif (null !== ( $fileInfo = $this->filter->filterFileInfo($data) )) {
                $flatten[] = [ [ 'file' ], $fileInfo ];

            } elseif (null !== $this->filter->filterStrval($data)) {
                $body = strval($data);
            }

            foreach ( $flatten as [ $fullpath, $value ] ) {
                if (null !== $this->filter->filterStrval($value)) {
                    $this->arr->set($fields, $fullpath, strval($value));
                }

                if (null !== ( $fileInfo = $this->filter->filterFileInfo($value) )) {
                    $this->arr->set($files, $fullpath,
                        curl_file_create($fileInfo->getRealPath(),
                            mime_content_type($fileInfo->getRealPath())
                        )
                    );
                }
            }

            if ($isNoFiles && $files) {
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

            $curlOptArray[ CURLOPT_POSTFIELDS ] = $requestBody;
        }

        if ($headers) {
            $curlOptArray[ CURLOPT_HTTPHEADER ] = $headers;
        }

        $curlOptArray = $this->formatter->mergeOptions($this->getOptArray(),
            $curlOptArray
        );

        $ch = curl_init($url);

        curl_setopt_array($ch, $curlOptArray);

        return $ch;
    }
}
