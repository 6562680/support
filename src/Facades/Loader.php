<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Loader as _Loader;
use Gzhegow\Support\Facades\Generated\Loader as LoaderGenerated;

class Loader extends LoaderGenerated
{
    public static function getInstance() : _Loader
    {
        return new _Loader(
            Str::getInstance(),
        );
    }
}
