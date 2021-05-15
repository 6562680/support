<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Fs as _Fs;
use Gzhegow\Support\Facades\Generated\Fs as FsGenerated;

class Fs extends FsGenerated
{
    public static function getInstance() : _Fs
    {
        return new _Fs(
            Filter::getInstance(),
            Str::getInstance()
        );
    }
}
