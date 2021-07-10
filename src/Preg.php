<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Domain\Preg\RegExp;
use Gzhegow\Support\SupportFactory;


/**
 * Preg
 */
class Preg implements IPreg
{
    /**
     * @var IStr
     */
    protected $str;


    /**
     * Constructor
     *
     * @param IStr $str
     */
    public function __construct(
        IStr $str
    )
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
    public function new($regex, string $delimiter = null, string $flags = null) : RegExp
    {
        return new RegExp($this, $this->str,
            $regex, $delimiter, $flags
        );
    }


    /**
     * @param mixed $regex
     *
     * @return bool
     */
    public function isShort($regex) : bool
    {
        return null !== $this->filterShort($regex);
    }

    /**
     * @param mixed $regex
     *
     * @return bool
     */
    public function isValid($regex) : bool
    {
        return null !== $this->filterValid($regex);
    }


    /**
     * @param mixed $regex
     *
     * @return null|string
     */
    public function filterShort($regex) : ?string
    {
        if (! is_string($regex)) {
            return null;
        }

        if (preg_quote($regex, '/') === $regex) {
            return null;
        }

        if (null === $this->filterValid('/' . $regex . '/')) {
            return null;
        }

        return $regex;
    }

    /**
     * @param mixed $regex
     *
     * @return null|string
     */
    public function filterValid($regex) : ?string
    {
        if (! is_string($regex)) {
            return null;
        }

        if (false === @preg_match($regex, null)) {
            return null;
        }

        return $regex;
    }


    /**
     * @param string|string[] $regex
     * @param string|string[] ...$regexes
     *
     * @return RegExp
     */
    public function concat($regex, ...$regexes) : string
    {
        return $this->new($regex)->concat(...$regexes)
            ->compile();
    }


    /**
     * @return IPreg
     */
    public static function me()
    {
        return SupportFactory::getInstance()->getPreg();
    }
}
