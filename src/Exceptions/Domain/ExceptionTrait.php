<?php

namespace Gzhegow\Support\Exceptions\Domain;

use Gzhegow\Support\Debug;


/**
 * ExceptionTrait
 */
trait ExceptionTrait
{
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
    protected $arguments = [];

    /**
     * @var callable[]
     */
    protected $pipeline = [];

    /**
     * @var array
     */
    protected $report;
    /**
     * @var array
     */
    protected $reportTrace;


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
        $debug = $this->newDebug();

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

            $trace[ $key ] = $debug->traceReport($step);
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
     * @param mixed        $payload
     * @param mixed        ...$arguments
     *
     * @return array
     */
    protected function parse($message, $payload = null, ...$arguments) : array
    {
        $name = str_replace('\\', '.', get_class($this));

        $code = $this->loadCode();

        [
            $message,
            $original,
        ] = $this->parseMessage($message);

        [
            $previous,
            $pipes,
            $arguments,
        ] = $this->parseArguments(...$arguments);

        $this->name = $name;

        $this->text = $original;
        $this->payload = $payload;
        $this->arguments = $arguments;

        $this->pipeline = $pipes;

        return [ $message, $code, $previous ];
    }


    /**
     * @param string|array $message
     *
     * @return array
     */
    protected function parseMessage($message) : array
    {
        $debug = $this->newDebug();

        $placeholders = is_array($message)
            ? $message
            : [ $message ];

        $original = strval(array_shift($placeholders));

        if ('' === $original) {
            throw new \InvalidArgumentException(
                'Text should be word', null, $this
            );
        }

        $text = $original;

        if ($placeholders) {
            $placeholders = $debug->args($placeholders);

            foreach ( array_keys($placeholders) as $idx ) {
                $placeholders[ $idx ] = $debug->printR($placeholders[ $idx ], 1);
            }

            $text = vsprintf($original,
                array_slice($placeholders, 0, substr_count(
                    str_replace('%%', "\0", $original),
                    '%'
                ))
            );
        }

        return [ $text, $original ];
    }

    /**
     * @param mixed ...$arguments
     *
     * @return array
     */
    protected function parseArguments(...$arguments) : array
    {
        $previous = null;
        $pipes = [];

        foreach ( $arguments as $idx => $argument ) {
            if (is_a($argument, \Throwable::class)) {
                if ($previous) {
                    throw new \InvalidArgumentException(
                        'Only one throwable could be passed as Previous', null, $this
                    );
                }

                $previous = $argument;

            } elseif (is_callable($argument)) {
                $pipes[] = $argument;

            } else {
                continue;
            }

            unset($arguments[ $idx ]);
        }

        return [ $previous, $pipes, $arguments ];
    }


    /**
     * @return array
     */
    abstract public function getTrace();


    /**
     * @return mixed
     */
    abstract public function loadCode() : int;
}
