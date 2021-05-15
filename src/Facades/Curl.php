<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Curl as _Curl;
use Gzhegow\Support\Facades\Generated\Curl as CurlGenerated;

class Curl extends CurlGenerated
{
    public static function getInstance() : _Curl
    {
        return new _Curl(
            Arr::getInstance(),
            Filter::getInstance(),
            Php::getInstance()
        );
    }
}
