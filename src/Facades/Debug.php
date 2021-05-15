<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Debug as _Debug;
use Gzhegow\Support\Facades\Generated\Debug as DebugGenerated;

class Debug extends DebugGenerated
{
    public static function getInstance() : _Debug
    {
        return new _Debug();
    }
}
