<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\BadFunctionCallException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Cli
 */
class Cli
{
    /**
     * @var Env
     */
    protected $env;
    /**
     * @var Php
     */
    protected $php;


    /**
     * Constructor
     *
     * @param Env $env
     * @param Php $php
     */
    public function __construct(Env $env, Php $php)
    {
        $this->env = $env;
        $this->php = $php;
    }


    /**
     * @param mixed ...$arguments
     */
    public function stop(...$arguments) : void
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Should be called in CLI mode');
        }

        $this->pause(...$arguments);

        exit(1);
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    public function pause(...$arguments) : array
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Should be called in CLI mode');
        }

        if ($arguments) var_dump(...$arguments);

        echo '> Press ENTER to continue...' . PHP_EOL;
        $h = fopen('php://stdin', 'r');
        fgets($h);
        fclose($h);

        return $arguments;
    }


    /**
     * @return string
     */
    public function readln() : string
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Should be called in CLI mode');
        }

        $h = fopen('php://stdin', 'r');
        $line = trim(fgets($h));
        fclose($h);

        return $line;
    }

    /**
     * @param string $search
     *
     * @return string
     */
    public function cin(string $search = '```') : string
    {
        if (PHP_SAPI !== 'cli') {
            throw new BadFunctionCallException('Should be called in CLI mode');
        }

        echo '> Enter text separating lines by pressing ENTER' . PHP_EOL;
        echo '> Type ' . $search . ' when you\'re done...' . PHP_EOL;

        $lines = [];
        $h = fopen('php://stdin', 'r');
        while ( false !== ( $line = fgets($h) ) ) {
            $line = trim($line);

            if (! $line) {
                echo '> Write `' . $search . '` when done...' . PHP_EOL;
                continue;
            }

            $expected_pos = mb_strlen($line) - mb_strlen($search);
            $pos = mb_strrpos($line, $search);

            // end found
            if ($expected_pos === $pos) {
                $line = substr($line, 0, $pos);
                if ($line) $lines[] = $line;
                break;

                // end is not found
            } else $lines[] = $line;
        }
        fclose($h);

        // results
        return implode(PHP_EOL, $lines);
    }


    /**
     * выполняет консольную команду через proc_open и возвращает данные или код ошибки
     *
     * @param string      $cmd
     * @param string|null $stdin
     * @param string|null $cwd
     * @param array|null  $env
     * @param array|null  $other_options
     *
     * @return array
     */
    public function run(string $cmd,
        string $stdin = null,
        string $cwd = null,
        array $env = null,
        array $other_options = null
    ) : array
    {
        $cwd = $cwd ?? getcwd();
        $env = $env ?? $this->env->getenv();

        if ('' === $cwd) {
            throw new InvalidArgumentException('Cwd should be not empty', func_get_args());
        }
        if (! is_dir($cwd)) {
            throw new InvalidArgumentException('Cwd must be a directory', func_get_args());
        }

        [ $env ] = $this->php->kwargs($env);
        [ $other_options ] = $this->php->kwargs($other_options);

        $env[ 'PATH' ] = $this->env->getenv('PATH');

        $h = proc_open($cmd, [
            0 => [ 'pipe', 'r' ],
            1 => [ 'pipe', 'w' ],
            2 => [ 'pipe', 'w' ],
        ], $ps, $cwd, $env, $other_options);

        if (! is_resource($h)) {
            throw new RuntimeException('Unable to start process for cmd: ' . $cmd);
        }

        if ($stdin) fwrite($ps[ 0 ], $stdin);
        fclose($ps[ 0 ]);

        // stdout
        $stdout = stream_get_contents($ps[ 1 ]);
        fclose($ps[ 1 ]);

        // stderr
        $stderr = stream_get_contents($ps[ 2 ]);
        fclose($ps[ 2 ]);

        // return code
        $code = proc_close($h);

        return [ $code, $stderr, $stdout ];
    }
}
