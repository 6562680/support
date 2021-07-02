<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Interfaces\LoaderInterface;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * LoaderF
 */
class Loader implements LoaderInterface
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
     * @var Str
     */
    protected $str;

    /**
     * @var array
     */
    protected $declaredClasses;

    /**
     * @var string
     */
    protected $includeFilepath;
    /**
     * @var array
     */
    protected $includeData = [];


    /**
     * Constructor
     *
     * @param Filter $filter
     * @param Path   $path
     * @param Str    $str
     */
    public function __construct(
        Filter $filter,
        Path $path,
        Str $str
    )
    {
        $this->filter = $filter;
        $this->path = $path;
        $this->str = $str;

        $path->withSeparator('\\');
        $path->withDelimiters([ '/' ]);
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
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isInstanceOf($value, $classes) : bool
    {
        return null !== $this->filterInstanceOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isClassOf($value, $classes) : bool
    {
        return null !== $this->filterClassOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isSubclassOf($value, $classes) : bool
    {
        return null !== $this->filterSubclassOf($value, $classes);
    }


    /**
     * @param object          $value
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public function filterInstanceOf($value, $classes) // : ?object
    {
        $list = $this->str->theWordvals($classes, true);

        foreach ( $list as $class ) {
            if ($value instanceof $class) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterClassOf($value, $classes) // : ?string|object
    {
        $list = $this->str->theWordvals($classes, true);

        $allowString = ( null !== ( $strval = $this->str->strval($value) ) );

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
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterSubclassOf($value, $classes) // : ?string|object
    {
        $list = $this->str->theWordvals($classes, true);

        $allowString = ( null !== ( $strval = $this->str->strval($value) ) );

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
     * @param object          $value
     * @param string|string[] ...$classes
     *
     * @return null|object
     */
    public function assertInstanceOf($value, $classes) // : ?object
    {
        if (null === $this->filterInstanceOf($value, $classes)) {
            throw new InvalidArgumentException('Value should be instance of: '
                . '[' . implode(', ', is_array($classes)
                    ? $classes
                    : [ $classes ]
                ) . ']'
            );
        }

        return $value;
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public function assertClassOf($value, $classes) // : ?string|object
    {
        if (null === $this->filterClassOf($value, $classes)) {
            throw new InvalidArgumentException('Value should be class of: '
                . '[' . implode(', ', is_array($classes)
                    ? $classes
                    : [ $classes ]
                ) . ']'
            );
        }

        return $value;
    }

    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return null|string|object
     */
    public function assertSubclassOf($value, $classes) // : ?string|object
    {
        if (null === $this->filterSubclassOf($value, $classes)) {
            throw new InvalidArgumentException('Value should be subclass of: '
                . '[' . implode(', ', is_array($classes)
                    ? $classes
                    : [ $classes ]
                ) . ']'
            );
        }

        return $value;
    }


    /**
     * @param mixed $classOrObject
     *
     * @return null|string
     */
    public function classVal($classOrObject) : ?string
    {
        $val = null;

        if (null !== ( $class = $this->filter->filterClass($classOrObject) )) {
            $val = $class;

        } elseif (is_object($classOrObject)) {
            if (null !== ( $reflectionClass = $this->filter->filterReflectionClass($classOrObject) )) {
                $val = $reflectionClass->getName();

            } else {
                $val = get_class($classOrObject);
            }
        }

        return $val;
    }

    /**
     * @param mixed $classOrObject
     *
     * @return string
     */
    public function theClassVal($classOrObject) : string
    {
        if (null === ( $val = $this->classVal($classOrObject) )) {
            throw new InvalidArgumentException(
                [ 'Invalid Class passed: %s', $classOrObject ]
            );
        }

        return $val;
    }


    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public function nsClass($classOrObject) : array
    {
        if (null === ( $class = $this->classVal($classOrObject) )) {
            throw new InvalidArgumentException('Class should be classval or object');
        }

        $namespace = '';
        $class = ltrim($class, '\\');

        if (false !== ( $pos = strrpos($class, '\\') )) {
            $namespace = substr($class, 0, $pos);
            $class = substr($class, $pos + 1);
        }

        return [ $namespace, $class ];
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string
     */
    public function namespace($classOrObject) : string
    {
        if (null === ( $class = $this->classVal($classOrObject) )) {
            throw new InvalidArgumentException('Class should be classval or object');
        }

        $namespace = '';
        $class = ltrim($class, '\\');

        if (false !== ( $pos = strrpos($class, '\\') )) {
            $namespace = substr($class, 0, $pos);
        }

        return $namespace;
    }

    /**
     * @param string|object $classOrObject
     *
     * @return string
     */
    public function className($classOrObject) : string
    {
        if (null === ( $class = $this->classVal($classOrObject) )) {
            throw new InvalidArgumentException('Class should be classval or object');
        }

        $class = ltrim($class, '\\');

        if (false !== ( $pos = strrpos($class, '\\') )) {
            $class = substr($class, $pos + 1);
        }

        return $class;
    }


    /**
     * @return Path
     */
    public function path() : Path
    {
        return $this->path;
    }


    /**
     * @param string $path
     *
     * @return string
     */
    public function pathOptimize(string $path) : string
    {
        $result = $this->path->optimize($path);

        return $result;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function pathNormalize(string $path) : string
    {
        $result = $this->path->normalize($path);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return array
     */
    public function pathSplit(...$parts) : array
    {
        $result = $this->path->split(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathJoin(...$parts) : string
    {
        $result = $this->path->join(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathConcat(...$parts) : string
    {
        $result = $this->path->concat(...$parts);

        return $result;
    }


    /**
     * @param string $path
     * @param int    $levels
     *
     * @return null|string
     */
    public function pathDirname(string $path, int $levels = null) : string
    {
        $result = $this->path->dirname($path, $levels);

        return $result;
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param int         $levels
     *
     * @return null|string
     */
    public function pathBasename(string $path, string $suffix = null, int $levels = null) : string
    {
        $result = $this->path->basename($path, $suffix, $levels);

        return $result;
    }

    /**
     * @param string|object $classOrObject
     * @param string|null   $base
     *
     * @return string
     */
    public function pathRelative($classOrObject, string $base = null) : ?string
    {
        if (null === ( $class = $this->classVal($classOrObject) )) {
            throw new InvalidArgumentException(
                [ 'Class should be valid class name or object: %s', $classOrObject ]
            );
        }

        $result = $this->path->relative($class, $base);

        return $result;
    }


    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     * @noinspection PhpIncludeInspection
     */
    public function include(string $filepath, array $data = [])
    {
        $this->includeFilepath = $filepath;
        $this->includeData = $data;

        $result = function () {
            extract($this->includeData);

            return include $this->includeFilepath;
        };

        $this->includeFilepath = null;
        $this->includeData = [];

        return $result;
    }

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     * @noinspection PhpIncludeInspection
     */
    public function includeOnce(string $filepath, array $data = [])
    {
        $this->includeFilepath = $filepath;
        $this->includeData = $data;

        $result = function () {
            extract($this->includeData);

            return include_once $this->includeFilepath;
        };

        $this->includeFilepath = null;
        $this->includeData = [];

        return $result;
    }


    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     * @noinspection PhpIncludeInspection
     */
    public function require(string $filepath, array $data = [])
    {
        $this->includeFilepath = $filepath;
        $this->includeData = $data;

        $result = ( function () {
            extract($this->includeData);

            return require $this->includeFilepath;
        } );

        $this->includeFilepath = null;
        $this->includeData = [];

        return $result;
    }

    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     * @noinspection PhpIncludeInspection
     */
    public function requireOnce(string $filepath, array $data = [])
    {
        $this->includeFilepath = $filepath;
        $this->includeData = $data;

        $result = ( function () {
            extract($this->includeData);

            return require_once $this->includeFilepath;
        } );

        $this->includeFilepath = null;
        $this->includeData = [];

        return $result;
    }


    /**
     * @param callable $filter
     * @param null|int $limit
     * @param int      $offset
     *
     * @return array
     */
    public function searchDeclaredClass(callable $filter, int $limit = null, int $offset = null) : array
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
