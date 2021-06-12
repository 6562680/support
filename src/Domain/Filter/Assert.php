<?php

namespace Gzhegow\Support\Domain\Filter;

use Gzhegow\Support\Debug;
use Gzhegow\Support\Filter;
use Gzhegow\Support\Domain\Filter\Generated\GeneratedAssert;


/**
 * Assert
 */
class Assert extends GeneratedAssert
{
    /**
     * @var Debug
     */
    protected $debug;


    /**
     * @var array
     */
    protected $message;
    /**
     * @var \RuntimeException
     */
    protected $throwable;


    /**
     * Constructor
     *
     * @param Debug  $debug
     * @param Filter $filter
     */
    public function __construct(
        Debug $debug,
        Filter $filter
    )
    {
        $this->debug = $debug;

        parent::__construct($filter);
    }


    /**
     * @param string|array|\Throwable $error
     * @param mixed                   ...$arguments
     *
     * @return static
     */
    public function withError($error, ...$arguments)
    {
        $this->message = $this->debug->messageVal($error, ...$arguments);
        $this->throwable = $this->filter->filterThrowable($error);

        return $this;
    }


    /**
     * @param string|array $text
     * @param mixed        ...$arguments
     *
     * @return null|string|array
     */
    public function message($text, ...$arguments) // : ?string|array
    {
        $message = null
            ?? ( func_num_args() ? $this->debug->messageVal($text, ...$arguments) : null )
            ?? $this->message;

        $this->message = null;

        return $message;
    }

    /**
     * @param string|array $text
     * @param mixed        ...$arguments
     *
     * @return null|string|array
     */
    public function messageOr($text, ...$arguments) // : ?string|array
    {
        $message = null
            ?? $this->message
            ?? ( func_num_args() ? $this->debug->messageVal($text, ...$arguments) : null );

        $this->message = null;

        return $message;
    }


    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\Throwable
     */
    public function throwable(\Throwable $throwable = null) : ?\Throwable
    {
        $throwable = null
            ?? ( func_num_args() ? $throwable : null )
            ?? $this->throwable;

        $this->throwable = null;

        return $throwable;
    }

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\Throwable
     */
    public function throwableOr(\Throwable $throwable = null) : ?\Throwable
    {
        $throwable = null
            ?? $this->throwable
            ?? ( func_num_args() ? $throwable : null );

        $this->throwable = null;

        return $throwable;
    }
}
