<?php

use Gzhegow\Support\Filter;
use Gzhegow\Support\Arr as _Arr;
use Gzhegow\Support\Domain\SupportFactory;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


defined('__ROOT__') or define('__ROOT__', __DIR__ . '/..');

require_once __DIR__ . '/../vendor/autoload.php';


/**
 * Gzhegow_Support_Generator
 */
class Gzhegow_Support_Generator
{
    /**
     * @param string      $str
     * @param null|string $needle
     * @param bool        $ignoreCase
     *
     * @return null|string
     */
    public function strStarts(string $str, string $needle = null, bool $ignoreCase = true) : ?string
    {
        $needle = $needle ?? '';

        if ('' === $str) return null;
        if ('' === $needle) return $str;

        $pos = $ignoreCase
            ? mb_stripos($str, $needle)
            : mb_strpos($str, $needle);

        $result = 0 === $pos
            ? mb_substr($str, mb_strlen($needle))
            : null;

        return $result;
    }

    /**
     * @param string $class
     *
     * @return array
     */
    public function loaderClassUses(string $class) : array
    {
        $uses = [];

        try {
            $rc = new \ReflectionClass($class);
        }
        catch ( ReflectionException $e ) {
            throw new \RuntimeException('Unable to reflect: ' . $class, null, $e);
        }

        $filepath = $rc->getFileName();

        $h = fopen($filepath, 'r');
        while ( ! feof($h) ) {
            $line = trim(fgets($h));

            if (null !== ( $cut = $this->strStarts($line, 'use ') )) {
                $uses[] = rtrim($cut, ';');
            }

            if (false
                || 0 === stripos($line, 'class ')
                || 0 === stripos($line, 'interface ')
                || 0 === stripos($line, 'trait ')
                || false !== stripos($line, ' trait ')
                || false !== stripos($line, ' trait ')
                || false !== stripos($line, ' trait ')
            ) {
                break;
            }
        }
        fclose($h);

        return $uses;
    }
}


/**
 * Gzhegow_Support_Generator_AssertBlueprint
 */
abstract class Gzhegow_Support_Generator_AssertBlueprint
{
    /**
     * @var Filter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }


    /**
     * @param string $customFilter
     * @param mixed  ...$arguments
     *
     * @return null|mixed
     */
    public function call(string $customFilter, ...$arguments)
    {
        if (null === ( $filtered = $this->filter->call($customFilter, ...$arguments) )) {
            throw $this->throwableOr(
                new InvalidArgumentException(
                    $this->messageOr('Invalid ' . $customFilter . ' passed: %s', ...$arguments)
                )
            );
        }

        return $filtered;
    }


    /**
     * @param string|array $text
     * @param mixed        ...$arguments
     *
     * @return null|string|array
     */
    abstract public function message($text, ...$arguments); // : ?string|array

    /**
     * @param string|array $text
     * @param mixed        ...$arguments
     *
     * @return null|string|array
     */
    abstract public function messageOr($text, ...$arguments); // : ?string|array


    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    abstract public function throwable(\Throwable $throwable = null); // : ?\Throwable;

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    abstract public function throwableOr(\Throwable $throwable = null); // : ?\Throwable
}


/**
 * Gzhegow_Support_Generator_TypeBlueprint
 */
abstract class Gzhegow_Support_Generator_TypeBlueprint
{
    /**
     * @var Filter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }


    /**
     * @param string $customFilter
     * @param mixed  ...$arguments
     *
     * @return null|mixed
     */
    public function call(string $customFilter, ...$arguments)
    {
        return null !== $this->filter->call($customFilter, ...$arguments);
    }
}
