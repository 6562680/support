<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Preg\RegExp;


/**
 * Preg
 */
class Preg
{
    /**
     * @var Str
     */
    protected $str;


    /**
     * Constructor
     *
     * @param Str $str
     */
    public function __construct(Str $str)
    {
        $this->str = $str;
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
        return new RegExp($this, $this->str,
            $regex, $delimiter, $flags
        );
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
        return $this->newRegExp($regex, $delimiter, $flags)
            ->compile();
    }


    /**
     * @param mixed $regex
     *
     * @return bool
     */
    public function isValid($regex) : bool
    {
        return is_string($regex)
            && ( false !== @preg_match($regex, null) );
    }


    /**
     * @param string|string[] $regex
     * @param string|string[] ...$regexes
     *
     * @return RegExp
     */
    public function concat($regex, ...$regexes) : string
    {
        return $this->newRegExp($regex)
            ->concat(...$regexes)
            ->compile();
    }
}
