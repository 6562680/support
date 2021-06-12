<?php

namespace Gzhegow\Support\Domain\Arr\ValueObjects;


/**
 * ExpandValue
 */
class ExpandValue
{
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @var int|string
     */
    protected $index;
    /**
     * @var int
     */
    protected $position;
    /**
     * @var int
     */
    protected $priority;

    /**
     * @var int
     */
    protected $indexInteger;
    /**
     * @var string
     */
    protected $indexString;


    /**
     * Constructor
     *
     * @param mixed       $value
     * @param int|string  $index
     * @param int         $position
     * @param int         $priority
     *
     * @param null|int    $indexInteger
     * @param null|string $indexString
     */
    public function __construct(
        $value,
        $index,
        int $position,
        int $priority = 0,

        int $indexInteger = null,
        string $indexString = null
    )
    {
        $this->value = $value;
        $this->position = $position;
        $this->priority = $priority;

        $this->index = $index;
        $this->indexInteger = $indexInteger ?? (int) $index;
        $this->indexString = $indexString ?? (string) $index;
    }


    /**
     * @return int|string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return int
     */
    public function getIndexInteger() : int
    {
        return $this->indexInteger;
    }

    /**
     * @return string
     */
    public function getIndexString() : string
    {
        return $this->indexString;
    }


    /**
     * @return int
     */
    public function getPosition() : int
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getPriority() : int
    {
        return $this->priority;
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
