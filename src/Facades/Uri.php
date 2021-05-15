<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Uri as _Uri;
use Gzhegow\Support\Facades\Generated\Uri as UriGenerated;

class Uri extends UriGenerated
{
    public static function getInstance() : _Uri
    {
        return new _Uri(
            Arr::getInstance(),
            Filter::getInstance(),
            Php::getInstance(),
            Str::getInstance()
        );
    }
}
