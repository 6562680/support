<?php

namespace Gzhegow\Support\Exceptions\Traits;

use Gzhegow\Support\Php;
use Gzhegow\Support\Debug;


/**
 * ExceptionTrait
 */
trait ExceptionTrait
{
    /**
     * @var Debug
     */
    protected $debug;
    /**
     * @var Php
     */
    protected $php;

    /**
     * @var string
     */
    protected $text;
    /**
     * @var mixed
     */
    protected $payload;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $reportTrace;

    /**
     * @var array
     */
    protected $report;


    /**
     * @return Debug
     */
    protected function newDebug() : Debug
    {
        return new Debug();
    }


    /**
     * @return array
     */
    protected function loadReportTrace() : array
    {
        $trace = [];

        $index = [];
        foreach ( $this->getTrace() as $idx => $step ) {
            $key = implode(':', [
                $step[ 'file' ] ?? '<file>',
                $step[ 'line' ] ?? '<line>',
            ]);

            $index[ $key ] = $index[ $key ] ?? 0;

            $key = isset($trace[ $key ])
                ? $key . ':' . $index[ $key ]++
                : $key;

            $trace[ $key ] = $this->debug->trace($step);
        }

        return $trace;
    }


    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }


    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }


    /**
     * @return array
     */
    public function getReport() : array
    {
        return [
            'name'    => $this->name,
            'text'    => $this->text,
            'payload' => $this->payload,
            'trace'   => $this->getReportTrace(),
        ];
    }

    /**
     * @return array
     */
    public function getReportTrace() : array
    {
        return $this->reportTrace = $this->reportTrace
            ?? $this->loadReportTrace();
    }


    /**
     * @param string|array $message
     * @param null         $payload
     *
     * @return void
     */
    protected function parse($message, $payload = null) : void
    {
        $this->debug = $this->newDebug();

        $placeholders = is_array($message)
            ? $message
            : [ $message ];

        $text = strval(array_shift($placeholders));
        if ('' === $text) {
            throw new \InvalidArgumentException('Message Text should be string/number', null, $this);
        }

        if ($placeholders) {
            $placeholders = $this->debug->args($placeholders);

            foreach ( array_keys($placeholders) as $idx ) {
                $placeholders[ $idx ] = $this->debug->printR($placeholders[ $idx ], 1);
            }

            $text = vsprintf($text,
                array_slice($placeholders, 0, substr_count(
                    str_replace('%%', "\0", $text),
                    '%'
                ))
            );
        }

        $this->text = $text;
        $this->payload = $payload;

        $this->name = str_replace('\\', '.', get_class($this));
    }


    /**
     * @return array
     */
    abstract public function getTrace();
}
