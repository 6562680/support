<?php

namespace Gzhegow\Support\Domain\Arr;


/**
 * ArrExpandVal
 */
class ArrExpandVal
{
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @var int|string
     */
    protected $idx;
    /**
     * @var int
     */
    protected $ordering;
    /**
     * @var int
     */
    protected $priority;

    /**
     * @var int
     */
    protected $idxInt;
    /**
     * @var string
     */
    protected $idxStr;


    /**
     * Constructor
     *
     * @param mixed       $value
     * @param int|string  $idx
     * @param int         $ordering
     * @param int         $priority
     *
     * @param null|int    $idxInt
     * @param null|string $idxStr
     */
    public function __construct($value, $idx, int $ordering, int $priority = 0,
        int $idxInt = null,
        string $idxStr = null
    )
    {
        $this->value = $value;
        $this->idx = $idx;
        $this->ordering = $ordering;
        $this->priority = $priority;

        $this->idxInt = $idxInt ?? (int) $idx;
        $this->idxStr = $idxStr ?? (string) $idx;
    }


    /**
     * @return int|string
     */
    public function getIdx()
    {
        return $this->idx;
    }

    /**
     * @return int
     */
    public function getIdxInt() : int
    {
        return $this->idxInt;
    }

    /**
     * @return string
     */
    public function getIdxStr() : string
    {
        return $this->idxStr;
    }


    /**
     * @return int
     */
    public function getOrdering() : int
    {
        return $this->ordering;
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
