<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Profiler as _Profiler;
use Gzhegow\Support\Facades\Generated\Profiler as ProfilerGenerated;

class Profiler extends ProfilerGenerated
{
    public static function getInstance() : _Profiler
    {
        return new _Profiler(
            Calendar::getInstance()
        );
    }
}
