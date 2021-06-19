<?php

namespace Gzhegow\Support\Exceptions\Traits;

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
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $text;
    /**
     * @var mixed
     */
    protected $payload;

    /**
     * @var array
     */
    protected $report;
    /**
     * @var array
     */
    protected $reportTrace;

    /**
     * @var callable[]
     */
    protected $pipeline = [];


    /**
     * @param mixed ...$arguments
     *
     * @return static
     */
    public function handle(...$arguments)
    {
        array_map(function ($callback) use ($arguments) {
            $callback($this, ...$arguments);
        }, $this->pipeline);

        return $this;
    }

    /**
     * @param mixed $carry
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public function process($carry, ...$arguments)
    {
        $result = array_reduce($this->pipeline,
            function ($carry, $callback) use ($arguments) {
                return $callback($this, $carry, ...$arguments);
            },
            $carry
        );

        return $result;
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

            $trace[ $key ] = $this->debug->traceReport($step);
        }

        return $trace;
    }


    /**
     * @return Debug
     */
    protected function newDebug() : Debug
    {
        return new Debug();
    }


    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
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
     * @return callable[]
     */
    public function getPipeline() : array
    {
        return $this->pipeline;
    }


    /**
     * @param callable $pipe
     *
     * @return $this
     */
    public function pipe(callable $pipe)
    {
        $this->pipeline[] = $pipe;

        return $this;
    }


    /**
     * @param string|array $message
     * @param null         $payload
     * @param mixed        ...$arguments
     *
     * @return array
     */
    protected function parse($message, $payload = null, ...$arguments) : array
    {
        $this->debug = $this->newDebug();

        $this->name = str_replace('\\', '.', get_class($this));

        $placeholders = is_array($message)
            ? $message
            : [ $message ];

        $text = strval(array_shift($placeholders));

        if ('' === $text) {
            throw new \InvalidArgumentException(
                'Message Text should be string/number', null, $this
            );
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

        $previous = null;
        foreach ( $arguments as $idx => $argument ) {
            if (is_a($argument, \Throwable::class)) {
                if ($previous) {
                    throw new \InvalidArgumentException(
                        'Only one throwable could be passed as Previous', null, $this
                    );
                }

                $previous = $argument;

            } elseif (is_callable($argument)) {
                $this->pipeline[] = $argument;

            } else continue;

            unset($arguments[ $idx ]);
        }

        if ($arguments) {
            $payload = is_array($payload)
                ? $payload
                : [ $payload ];

            $payload = array_merge($payload, $arguments);
        }
        $this->payload = $payload;

        return [
            $message = $this->text,
            $code = crc32($this->name),
            $previous,
        ];
    }


    /**
     * @return array
     */
    abstract public function getTrace();
}
