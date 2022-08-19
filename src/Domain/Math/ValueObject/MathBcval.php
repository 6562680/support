<?php

namespace Gzhegow\Support\Domain\Math\ValueObject;


/**
 * MathBcval
 */
class MathBcval
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
    private function __construct(string $value)
    {
        $isNegative = 0 === strpos($value, '-');

        $this->value = '-0' !== $value
            ? $value : '0';

        $this->minus = $isNegative
            ? '-' : '';

        $this->abs = $isNegative
            ? substr($this->value, 1) : $this->value;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }


    /**
     * @param string $value
     *
     * @return static
     */
    public static function fromValidValue(string $value)
    {
        return new static($value);
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
        return $this->abs;
    }

    /**
     * @return string
     */
    public function getMinus() : string
    {
        return $this->minus;
    }
}