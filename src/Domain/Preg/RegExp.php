<?php

namespace Gzhegow\Support\Domain\Preg;

use Gzhegow\Support\IStr;
use Gzhegow\Support\IPreg;
use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * RegExp
 */
class RegExp
{
    /**
     * @var IPreg
     */
    protected $preg;


    /**
     * @var IStr
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
     * @param IPreg           $preg
     *
     * @param IStr            $str
     *
     * @param string|string[] $regex
     * @param null|string     $delimiter
     * @param null|string     $flags
     */
    public function __construct(
        IPreg $preg,

        IStr $str,

        $regex,
        string $delimiter = null,
        string $flags = null
    )
    {
        $this->preg = $preg;
        $this->str = $str;

        if (null !== $delimiter) $this->setDelimiter($delimiter);
        if (null !== $flags) $this->setFlags($flags);

        $this->concat($regex);
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
     * @param string $delimiter
     *
     * @return null|array
     */
    protected function loadDelimiters(string $delimiter) : ?array
    {
        if (false === ( $pos = strpos(static::$delimitersAllowed[ 0 ], $delimiter) )) {
            return null;
        }

        $delimiters = [
            static::$delimitersAllowed[ 0 ][ $pos ],
            static::$delimitersAllowed[ 1 ][ $pos ],
        ];

        return $delimiters;
    }


    /**
     * @param string $delimiter
     *
     * @return static
     */
    protected function setDelimiter(string $delimiter)
    {
        if ('' === $delimiter) {
            throw new InvalidArgumentException('Delimiter should be non-empty string');
        }

        if (null === ( $delimiters = $this->loadDelimiters($delimiter) )) {
            throw new InvalidArgumentException('Invalid delimiter passed: ' . $delimiter);
        }

        $this->delimiters = $delimiters;

        return $this;
    }

    /**
     * @param string $flags
     *
     * @return static
     */
    protected function setFlags(string $flags)
    {
        $uniq = [];

        $letters = '' !== $flags
            ? array_filter(str_split($flags))
            : [];

        foreach ( $letters as $letter ) {
            if (false === strpos(static::$flagsAllowed, $letter)) {
                throw new InvalidArgumentException('Invalid flag passed: ' . $letter);
            }

            $uniq[ $letter ] = true;
        }

        $this->flags = $uniq
            ? implode('', array_keys($uniq))
            : '';

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
            $delimiters = $this->loadDelimiters($r[ 0 ]);

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
     * @return static
     */
    public function d(string $delimiter)
    {
        return $this->setDelimiter($delimiter);
    }

    /**
     * @param string $flags
     *
     * @return static
     */
    public function f(string $flags)
    {
        return $this->setFlags($flags);
    }


    /**
     * @var string[]
     */
    protected static $delimitersAllowed = [ '/#+%{([<', '/#+%})]>' ];

    /**
     * @var string
     */
    protected static $flagsAllowed = 'eimsuxADJSUX';
}
