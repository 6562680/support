<?php

use Gzhegow\Support\IStr;
use Gzhegow\Support\IFilter;
use Gzhegow\Support\ILoader;


defined('__ROOT__') or define('__ROOT__', __DIR__ . '/..');

require_once __DIR__ . '/../vendor/autoload.php';


/**
 * Gzhegow_Support_Generator
 */
class Gzhegow_Support_Generator
{
    /**
     * @var ILoader
     */
    protected $loader;
    /**
     * @var IStr
     */
    protected $str;


    /**
     * Constructor
     *
     * @param ILoader $loader
     * @param IStr    $str
     */
    public function __construct(
        ILoader $loader,
        IStr $str
    )
    {
        $this->loader = $loader;
        $this->str = $str;
    }


    /**
     * @return IStr
     */
    public function getStr() : IStr
    {
        return $this->str;
    }

    /**
     * @return ILoader
     */
    public function getLoader() : ILoader
    {
        return $this->loader;
    }
}


/**
 * Gzhegow_Support_Generator_AssertBlueprint
 */
abstract class Gzhegow_Support_Generator_AssertBlueprint
{
    /**
     * @var IFilter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param IFilter $filter
     */
    public function __construct(
        IFilter $filter
    )
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
            throw $this->getThrowableOr(
                new InvalidArgumentException($this->getErrorOr(
                    'Invalid ' . $customFilter . ' passed: %s', ...$arguments
                ))
            );
        }

        return $filtered;
    }


    /**
     * @param null|string|array $text
     * @param array             ...$arguments
     *
     * @return null|array
     */
    abstract public function getError($text = null, ...$arguments) : ?array;

    /**
     * @param null|string|array $text
     * @param array             ...$arguments
     *
     * @return null|array
     */
    abstract public function getErrorOr($text = null, ...$arguments) : ?array;


    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    abstract public function getThrowable(\Throwable $throwable = null); // : ?\Throwable

    /**
     * @param null|\Throwable $throwable
     *
     * @return null|\RuntimeException
     */
    abstract public function getThrowableOr(\Throwable $throwable = null); // : ?\Throwable
}


/**
 * Gzhegow_Support_Generator_TypeBlueprint
 */
abstract class Gzhegow_Support_Generator_TypeBlueprint
{
    /**
     * @var IFilter
     */
    protected $filter;


    /**
     * Constructor
     *
     * @param IFilter $filter
     */
    public function __construct(IFilter $filter)
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