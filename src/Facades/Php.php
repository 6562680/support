<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Php as _Php;
use Gzhegow\Support\Facades\Generated\Php as PhpGenerated;

class Php extends PhpGenerated
{
    public static function getInstance() : _Php
    {
        return new _Php(
            Filter::getInstance()
        );
    }
}
