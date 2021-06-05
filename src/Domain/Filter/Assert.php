<?php

namespace Gzhegow\Support\Domain\Filter;

use Gzhegow\Support\Domain\Filter\Generated\GeneratedAssert;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Assert
 */
class Assert extends GeneratedAssert
{
    /**
     * @var string|array
     */
    protected $message;
    /**
     * @var \RuntimeException
     */
    protected $throwable;


    /**
     * @param string|array|\Throwable $message
     * @param mixed                   ...$arguments
     *
     * @return static
     */
    public function message($message, ...$arguments)
    {
        if (is_object($message) && is_a($message, \Throwable::class)) {
            $this->throwable = $message;

        } elseif (is_string($message) || is_array($message)) {
            if ('' === $message) {
                throw new InvalidArgumentException('Message should be non-empty string');
            }

            if ($arguments) {
                $array = is_array($message)
                    ? $message
                    : [ $message ];

                $message = array_merge($array, $arguments);
            }

            $this->message = $message;

        } else {
            throw new InvalidArgumentException('Message should be array or string');
        }

        return $this;
    }


    /**
     * @param mixed ...$arguments
     *
     * @return null|string|array
     */
    public function flushMessage(...$arguments)
    {
        if (! isset($this->message)) {
            return null;
        }

        $message = $this->message;

        $this->message = null;

        if ($arguments) {
            $array = is_array($message)
                ? $message
                : [ $message ];

            $message = array_merge($array, $arguments);
        }

        return $message;
    }

    /**
     * @return \RuntimeException
     */
    public function flushThrowable()
    {
        if (! isset($this->throwable)) {
            return null;
        }

        $throwable = $this->throwable;

        $this->throwable = null;

        return $throwable;
    }
}
