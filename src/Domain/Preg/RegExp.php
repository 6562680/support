<?php

namespace Gzhegow\Support\Domain\Preg;

use Gzhegow\Support\Str;
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
     * @var Str
     */
    protected $str;

    /**
     * @var string[]
     */
    protected $regex = [];

    /**
     * @var string[]
     */
    protected $delimiters;
    /**
     * @var string[]
     */
    protected $delimitersDefault = [ '/', '/' ];

    /**
     * @var string
     */
    protected $flags;
    /**
     * @var string
     */
    protected $flagsDefault = '';


    /**
     * Constructor
     *
     * @param Preg            $preg
     * @param Str             $str
     *
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     */
    public function __construct(
        Preg $preg,
        Str $str,

        $regex,
        string $delimiter = null,
        string $flags = null
    )
    {
        $this->preg = $preg;
        $this->str = $str;

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
    protected function addRegex(...$regex)
    {
        array_walk_recursive($regex, function (string $r) {
            $delimiters = $this->fetchDelimiters($r[ 0 ]);
            if (! $this->delimiters) {
                $this->setDelimiter($delimiters[ 0 ]);
            }

            $parts = explode($delimiters[ 1 ], $r);
            $flags = array_pop($parts);
            if (! $this->flags) {
                $this->setFlags($flags);
            }

            [ $rr ] = $this->str->match($delimiters[ 0 ], $delimiters[ 1 ], $r);

            $this->regex[] = $rr;
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
            $this->preg->isValid($r)
                ? ( $this->addRegex($r) )
                : ( $this->regex[] = $r );
        });

        return $this;
    }


    /**
     * @param string $delimiter
     *
     * @return null|array
     */
    public function fetchDelimiters(string $delimiter) : ?array
    {
        if (false === ( $pos = strpos(static::$_delimiters[ 0 ], $delimiter) )) {
            return null;
        }

        $delimiters = [
            static::$_delimiters[ 0 ][ $pos ],
            static::$_delimiters[ 1 ][ $pos ],
        ];

        return $delimiters;
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

        $delimiters = $this->delimiters
            ?? $this->delimitersDefault;

        $flags = $this->flags
            ?? $this->flagsDefault;

        $regex = '';
        foreach ( $this->regex as $part ) {
            $regex .= is_array($part)
                ? preg_quote($part[ 0 ], '/')
                : $part;
        }

        $result = ''
            . $delimiters[ 0 ]
            . $regex
            . $delimiters[ 1 ]
            . $flags;


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

        if (null === ( $delimiters = $this->fetchDelimiters($delimiter) )) {
            throw new InvalidArgumentException('Invalid delimiter passed: ' . $delimiter);
        }

        $this->delimiters = $delimiters;

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
