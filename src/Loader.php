<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * Loader
 */
class Loader
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var Path
     */
    protected $path;
    /**
     * @var Php
     */
    protected $php;


    /**
     * @var array
     */
    protected $declaredClasses;



    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Path   $path
     * @param Php    $php
     */
    public function __construct(
        Filter $filter,
        Path $path,
        Php $php
    )
    {
        $this->filter = $filter;
        $this->php = $php;
        $this->path = $path;

        $path->using('\\');
    }


    /**
     * @return array
     */
    protected function loadDeclaredClasses() : array
    {
        $map = [];

        foreach ( get_declared_classes() as $class ) {
            $map[ '\\' . ltrim($class, '\\') ] = true;
        }

        return $map;
    }


    /**
     * @return array
     */
    public function getDeclaredClasses() : array
    {
        return $this->declaredClasses = $this->declaredClasses
            ?? $this->loadDeclaredClasses();
    }


    /**
     * @param object          $value
     * @param string|string[] ...$classes
     *
     * @return bool
     */
    public function isInstanceOf($value, ...$classes) : bool
    {
        return null !== $this->filterInstanceOf($value, ...$classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return bool
     */
    public function isClassOf($value, ...$classes) : bool
    {
        return null !== $this->filterClassOf($value, ...$classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return bool
     */
    public function isSubclassOf($value, ...$classes) : bool
    {
        return null !== $this->filterSubclassOf($value, ...$classes);
    }


    /**
     * @param object          $value
     * @param string|string[] ...$classes
     *
     * @return null|object
     */
    public function filterInstanceOf($value, ...$classes) // : ?object
    {
        $list = $this->php->listvalFlatten(...$classes);

        foreach ( $list as $class ) {
            if ($value instanceof $class) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public function filterClassOf($value, ...$classes) // : ?string|object
    {
        $list = $this->php->listvalFlatten(...$classes);

        $allowString = ( null !== ( $strval = $this->php->strval($value) ) );

        foreach ( $list as $class ) {
            if ($allowString && is_a($strval, $class, true)) {
                return $value;

            } elseif (is_a($value, $class)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public function filterSubclassOf($value, ...$classes) // : ?string|object
    {
        $list = $this->php->listvalFlatten(...$classes);

        $allowString = ( null !== ( $strval = $this->php->strval($value) ) );

        foreach ( $list as $class ) {
            if ($allowString && is_subclass_of($strval, $class, true)) {
                return $value;

            } elseif (is_subclass_of($value, $class)) {
                return $value;
            }
        }

        return null;
    }


    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public function nsClass($classOrObject) : array
    {
        if (null === ( $class = $this->php->classval($classOrObject) )) {
            throw new InvalidArgumentException('Class should be classval or object');
        }

        $namespace = substr($class, 0, strrpos($class, '\\'));
        $class = substr($class, strrpos($class, '\\') + 1);

        return [ $namespace, $class ];
    }


    /**
     * @param string|object $classOrObject
     *
     * @return null|string
     */
    public function namespace($classOrObject) : ?string
    {
        if (null === ( $class = $this->php->classval($classOrObject) )) {
            throw new InvalidArgumentException('Class should be classval or object');
        }

        $result = substr($class, 0, strrpos($class, '\\'));

        return $result;
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string
     */
    public function className($classOrObject) : string
    {
        if (null === ( $class = $this->php->classval($classOrObject) )) {
            throw new InvalidArgumentException('Class should be classval or object');
        }

        $result = substr($class, strrpos($class, '\\') + 1);

        return $result;
    }


    /**
     * @param string|object $classOrObject
     * @param null|string   $suffix
     * @param null|int      $limit
     *
     * @return string
     */
    public function basename($classOrObject, string $suffix = null, int $limit = null) : ?string
    {
        if (null === ( $class = $this->php->classval($classOrObject) )) {
            throw new InvalidArgumentException('Class should be classval or object');
        }

        $result = $this->path->basename($class, $suffix, $limit);

        return $result;
    }

    /**
     * @param string|object $classOrObject
     * @param string|null   $base
     *
     * @return string
     */
    public function basepath($classOrObject, string $base = null) : ?string
    {
        if (null === ( $class = $this->php->classval($classOrObject) )) {
            throw new InvalidArgumentException('Class should be classval or object');
        }

        $result = $this->path->basepath($class, $base);

        return $result;
    }


    /**
     * @param callable $filter
     * @param null|int $limit
     * @param int      $offset
     *
     * @return array
     */
    public function searchDeclaredClass(callable $filter, int $limit = null, int $offset = 0) : array
    {
        $result = [];

        foreach ( $this->getDeclaredClasses() as $class => $bool ) {
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
