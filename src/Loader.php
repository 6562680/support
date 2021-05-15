<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Loader
 */
class Loader
{
    /**
     * @var Str
     */
    protected $str;


    /**
     * @var array
     */
    protected $classMap;


    /**
     * Constructor
     *
     * @param Str $str
     */
    public function __construct(
        Str $str
    )
    {
        $this->str = $str;
    }


    /**
     * @return array
     */
    public function loadClassMap() : array
    {
        $map = [];

        foreach ( get_declared_classes() as $class ) {
            $map[ '\\' . ltrim($class, '\\') ] = true;
        }

        return $map;
    }


    /**
     * @param string|object $classOrObject
     *
     * @return array
     */
    public function split($classOrObject) : array
    {
        $class = is_object($classOrObject)
            ? get_class($classOrObject)
            : $classOrObject;

        if (! is_string($class)) {
            throw new InvalidArgumentException('Class should be string or object');
        }

        $result = explode('\\', $class);

        return $result;
    }


    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public function nsclass($classOrObject) : array
    {
        $array = $this->split($classOrObject);

        $class = array_pop($array);
        $namespace = implode($separator = '\\', $array) ?: null;

        return [ $namespace, $class ];
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string
     */
    public function class($classOrObject) : string
    {
        $array = $this->split($classOrObject);

        $result = array_pop($array);

        return $result;
    }

    /**
     * @param string|object $classOrObject
     *
     * @return null|string
     */
    public function namespace($classOrObject) : ?string
    {
        $array = $this->split($classOrObject);

        array_pop($array);

        $result = implode('\\', $array);

        return $result;
    }


    /**
     * @param mixed       $classOrObject
     * @param string|null $base
     *
     * @return string
     */
    public function baseclass($classOrObject, string $base = null) : ?string
    {
        $class = is_object($classOrObject)
            ? get_class($classOrObject)
            : $classOrObject;

        if (! is_string($class)) {
            throw new InvalidArgumentException('Class should be string or object');
        }

        $result = $this->str->starts($class, $base);

        return $result;
    }


    /**
     * @param callable $filter
     * @param null|int $limit
     * @param int      $offset
     *
     * @return array
     */
    public function search(callable $filter, int $limit = null, int $offset = 0) : array
    {
        $this->classMap = $this->classMap ?? $this->loadClassMap();

        $result = [];

        foreach ( $this->classMap as $class => $bool ) {
            if (! $filter($class)) {
                continue;
            }

            $result[] = $class;

            if (0 < $offset--) continue;
            if (isset($limit) && ! $limit--) break;
        }

        return $result;
    }
}
