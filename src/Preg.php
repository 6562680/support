<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Preg\RegExp;


/**
 * Preg
 */
class Preg
{
    /**
     * @var Type
     */
    protected $type;


    /**
     * Constructor
     *
     * @param Type $type
     */
    public function __construct(Type $type)
    {
        $this->type = $type;
    }


    /**
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     *
     * @return RegExp
     */
    public function newRegExp($regex, string $delimiter = null, string $flags = null) : RegExp
    {
        return new RegExp($this, $regex, $delimiter, $flags);
    }

    /**
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     *
     * @return RegExp
     */
    public function new($regex, string $delimiter = null, string $flags = null) : string
    {
        return $this->newRegExp($regex, $delimiter, $flags)->compile();
    }


    /**
     * @param string $regex
     *
     * @return bool
     */
    public function isValid(string $regex) : bool
    {
        return false !== @preg_match($regex, null);
    }


    /**
     * @param string|string[] $regex
     * @param string|string[] ...$parts
     *
     * @return RegExp
     */
    public function concat($regex, ...$parts) : string
    {
        return $this->newRegExp($regex)->concat(...$parts)->compile();
    }
}
