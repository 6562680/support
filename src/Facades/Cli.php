<?php

namespace Gzhegow\Support\Facades;

use Gzhegow\Support\Cli as _Cli;
use Gzhegow\Support\Facades\Generated\Cli as CliGenerated;

class Cli extends CliGenerated
{
    public static function getInstance() : _Cli
    {
        return new _Cli(
            Env::getInstance(),
            Php::getInstance()
        );
    }
}
