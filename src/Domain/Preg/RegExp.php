<?php

namespace Gzhegow\Support\Domain\Preg;

use Gzhegow\Support\Preg;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * RegExp
 */
class RegExp
{
    /**
     * @var Preg
     */
    protected $preg;


    /**
     * @var string[]
     */
    protected $regex = [];

    /**
     * @var string[]
     */
    protected $delimiters = [ '/', '/' ];
    /**
     * @var string
     */
    protected $flags = '';


    /**
     * Constructor
     *
     * @param Preg            $preg
     * @param string|string[] $regex
     * @param string          $delimiter
     * @param string          $flags
     */
    public function __construct(
        Preg $preg,

        $regex, string $delimiter = null, string $flags = null
    )
    {
        $this->preg = $preg;

        if (null !== $delimiter) $this->setDelimiter($delimiter);
        if (null !== $flags) $this->setFlags($flags);

        is_array($regex)
            ? $this->addQuote($regex)
            : $this->add($regex);
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->compile();
    }


    /**
     * @param string|string[] ...$parts
     *
     * @return static
     */
    public function __invoke(...$parts)
    {
        $this->concat(...$parts);

        return $this;
    }

    /**
     * @param string ...$regex
     *
     * @return static
     */
    protected function addQuote(...$regex)
    {
        array_walk_recursive($regex, function (string $r) {
            $this->regex[] = [ $r ];
        });

        return $this;
    }

    /**
     * @param mixed ...$regex
     *
     * @return static
     */
    protected function add(...$regex)
    {
        array_walk_recursive($regex, function (string $r) {
            $this->regex[] = $r;
        });

        return $this;
    }


    /**
     * @param string|string[] ...$parts
     *
     * @return static
     */
    public function concat(...$parts)
    {
        foreach ( $parts as $part ) {
            is_array($part)
                ? $this->addQuote($part)
                : $this->add($part);
        }

        return $this;
    }

    /**
     * @param null|string $delimiter
     * @param null|string $flags
     *
     * @return string
     */
    public function compile(string $delimiter = null, string $flags = null) : string
    {
        if (null !== $delimiter) $this->setDelimiter($delimiter);
        if (null !== $flags) $this->setFlags($flags);

        $regex = '';
        foreach ( $this->regex as $part ) {
            $regex .= is_array($part)
                ? preg_quote($part[ 0 ], '/')
                : $part;
        }

        $result = ''
            . $this->delimiters[ 0 ]
            . $regex
            . $this->delimiters[ 1 ]
            . $this->flags;

        if (! $this->preg->isValid($result)) {
            throw new RuntimeException('Unable to compile regex: ' . $regex, $this);
        }

        return $result;
    }


    /**
     * @param string $delimiter
     *
     * @return $this
     */
    public function d(string $delimiter)
    {
        return $this->setDelimiter($delimiter);
    }

    /**
     * @param string $flags
     *
     * @return $this
     */
    public function f(string $flags)
    {
        return $this->setFlags($flags);
    }


    /**
     * @param string $delimiter
     *
     * @return $this
     */
    protected function setDelimiter(string $delimiter)
    {
        if ('' === $delimiter) {
            throw new InvalidArgumentException('Delimiter should be non-empty string');
        }

        if (false === ( $idx = strpos(static::$_delimiters[ 0 ], $delimiter) )) {
            throw new InvalidArgumentException('Invalid delimiter passed: ' . $delimiter);
        }

        $this->delimiters = [
            static::$_delimiters[ 0 ][ $idx ],
            static::$_delimiters[ 1 ][ $idx ],
        ];

        return $this;
    }

    /**
     * @param string $flags
     *
     * @return $this
     */
    protected function setFlags(string $flags)
    {
        $uniq = [];

        $split = array_filter(str_split($flags));
        foreach ( $split as $f ) {
            if (false === strpos(static::$_flags, $f)) {
                throw new InvalidArgumentException('Invalid flag passed: ' . $f);
            }

            $uniq[ $f ] = true;
        }

        $this->flags = $uniq
            ? implode('', array_keys($uniq))
            : '';

        return $this;
    }


    /**
     * @var string[]
     */
    protected static $_delimiters = [ '/#+%{([<', '/#+%})]>' ];

    /**
     * @var string
     */
    protected static $_flags = 'eimsuxADJSUX';
}
