<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Net as _Net;
use Gzhegow\Support\Facades\Generated\Net as NetGenerated;

class Net extends NetGenerated
{
    public static function getInstance() : _Net
    {
        return new _Net(
            Str::getInstance(),
        );
    }
}
