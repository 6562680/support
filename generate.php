<?php

set_error_handler(function (
    $errno,
    $errstr,
    $errfile,
    $errline
) {
    $exception = new \Gzhegow\Support\Exceptions\Error($errstr, null, $errno);

    ( function ($errno, $errfile, $errline) {
        $this->file = $errfile;
        $this->line = $errline;
    } )->call($exception, $errno, $errfile, $errline);

    throw $exception;
});

try {
    require_once __DIR__ . '/generator/generate.assert.php';
    require_once __DIR__ . '/generator/generate.type.php';
    require_once __DIR__ . '/generator/generate.facades.php';
    require_once __DIR__ . '/generator/generate.interfaces.php';
}
catch ( \Throwable $e ) {
    dd($e);
}
