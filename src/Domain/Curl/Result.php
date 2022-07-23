<?php

namespace Gzhegow\Support\Domain\Curl;

/**
 * Class
 */
class Result
{
    /**
     * @var mixed
     */
    public $content;
    /**
     * @var string
     */
    public $url;
    /**
     * @var resource|\CurlHandle
     */
    public $ch;
}