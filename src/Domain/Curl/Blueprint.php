<?php

namespace Gzhegow\Support\Domain\Curl;

use Gzhegow\Support\Arr;
use Gzhegow\Support\Type;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Blueprint
 */
class Blueprint
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
     * @var Type
     */
    protected $type;

    /**
     * @var Formatter
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
     * @param Arr       $arr
     * @param Filter    $filter
     * @param Type      $type
     *
     * @param Formatter $formatter
     *
     * @param array     $curlOptArray
     */
    public function __construct(
        Arr $arr,
        Filter $filter,
        Type $type,

        Formatter $formatter,

        array $curlOptArray = []
    )
    {
        $this->arr = $arr;
        $this->type = $type;

        $this->formatter = $formatter;

        $this->curlOptArrayInit = $curlOptArray;
        $this->curlOptArray = $this->curlOptArrayInit;
        $this->filter = $filter;
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
     * @return resource
     */
    public function get(string $url, $data = null, array $headers = [])
    {
        return $this->request(Formatter::METHOD_GET, $url, $data, $headers);
    }


    /**
     * @param       $opt
     * @param mixed $value
     *
     * @return static
     */
    public function setOpt(string $opt, $value)
    {
        if (null === ( $optCode = $this->formatter->detectOptCode($opt) )) {
            throw new InvalidArgumentException('Invalid CURL option: ' . $opt, func_get_args());
        }

        $this->curlOptArray[ $opt ] = $value;

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
     * @return resource
     */
    public function head(string $url, array $headers = [])
    {
        return $this->request(Formatter::METHOD_HEAD, $url, null, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource
     */
    public function options(string $url, array $headers = [])
    {
        return $this->request(Formatter::METHOD_OPTIONS, $url, null, $headers);
    }


    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function post(string $url, $data = null, array $headers = [])
    {
        return $this->request(Formatter::METHOD_POST, $url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function patch(string $url, $data = null, array $headers = [])
    {
        return $this->request(Formatter::METHOD_PATCH, $url, $data, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function put(string $url, $data = null, array $headers = [])
    {
        return $this->request(Formatter::METHOD_PUT, $url, $data, $headers);
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return resource
     */
    public function delete(string $url, array $headers = [])
    {
        return $this->request(Formatter::METHOD_DELETE, $url, null, $headers);
    }


    /**
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function purge(string $url, $data = null, array $headers = [])
    {
        return $this->request(Formatter::METHOD_PURGE, $url, $data, $headers);
    }


    /**
     * @param string $method
     * @param string $url
     * @param mixed  $data
     * @param array  $headers
     *
     * @return resource
     */
    public function request(string $method, string $url, $data = null, array $headers = [])
    {
        $httpMethod = $this->formatter->detectHttpMethod($method);

        $isMethodDelete = ( Formatter::METHOD_DELETE === $httpMethod );
        $isMethodGet = ( Formatter::METHOD_GET === $httpMethod );
        $isMethodHead = ( Formatter::METHOD_HEAD === $httpMethod );
        $isMethodOptions = ( Formatter::METHOD_OPTIONS === $httpMethod );

        $isNoData = 0
            || $isMethodDelete
            || $isMethodHead
            || $isMethodOptions;
        $isNoFiles = 0
            || $isMethodGet;
        $isNoBody = 0
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
            /** @var \SplFileInfo $fileInfo */

            if ($isNoData) {
                throw new RuntimeException(
                    'Unable to send data using method: ' . $httpMethod
                );
            }

            if (is_array($data)) {
                foreach ( $this->arr->walk($data) as $fullpath => $value ) {
                    if ($this->type->isFileInfo($fileInfo)) {
                        $this->arr->set($files, $fullpath,
                            $file = curl_file_create($fileInfo->getRealPath(),
                                mime_content_type($fileInfo->getRealPath())
                            )
                        );

                        continue;
                    }

                    if (null !== ( $strval = $this->filter->filterStringable($value) )) {
                        $this->arr->set($fields, $fullpath, $strval);

                        continue;
                    }
                }

            } elseif ($this->type->isFileInfo($fileInfo = $data)) {
                $files[ 'file' ] = curl_file_create($fileInfo->getRealPath(),
                    mime_content_type($fileInfo->getRealPath())
                );

            } elseif (null !== ( $strval = $this->filter->filterStringable($data) )) {
                $body = $strval;

            }

            if ($isNoFiles && $files) {
                throw new InvalidArgumentException('Unable to send files using method: ' . $httpMethod);
            }

            if ($body) {
                if ($isNoBody) {
                    throw new InvalidArgumentException('Unable to send raw body using method: ' . $httpMethod);
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

            $opts[ CURLOPT_POSTFIELDS ] = $requestBody;
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
