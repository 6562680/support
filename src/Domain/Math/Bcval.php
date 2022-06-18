<?php

namespace Gzhegow\Support\Domain\Math;


use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Bcval
 */
class Bcval
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $abs;
    /**
     * @var string
     */
    protected $minus;


    /**
     * Constructor
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (! strlen($value)) {
            throw new InvalidArgumentException('Value should be non-empty string');
        }

        $this->value = '-0' === $value
            ? '0'
            : $value;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }


    /**
     * @param string $abs
     *
     * @return static
     */
    public function withAbs(string $abs)
    {
        if (! strlen($abs)) {
            throw new InvalidArgumentException('Abs should be non-empty string');
        }

        $this->abs = $abs;

        return $this;
    }

    /**
     * @param string $minus
     *
     * @return static
     */
    public function withMinus(string $minus)
    {
        $this->minus = $minus;

        if ('' !== $minus) {
            if ($this->value[ 0 ] !== '-') {
                $this->value = '-' . $this->value;
            }
        }

        return $this;
    }


    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }


    /**
     * @return string
     */
    public function getAbs() : string
    {
        if (null === $this->abs) {
            $minus = $this->getMinus();

            $this->abs = $minus
                ? substr($this->value, 1)
                : $this->value;
        }

        return $this->abs;
    }

    /**
     * @return string
     */
    public function getMinus() : string
    {
        if (null === $this->minus) {
            $this->minus = 0 === strpos($this->value, '-')
                ? '-'
                : '';
        }

        return $this->minus;
    }


    /**
     * @return bool
     */
    public function hasAbs() : bool
    {
        return null !== $this->abs;
    }

    /**
     * @return bool
     */
    public function hasMinus() : bool
    {
        return null !== $this->minus;
    }
}