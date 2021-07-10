<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;


/**
 * ZLoader
 */
class ZLoader implements ILoader
{
    /**
     * @var IFilter
     */
    protected $filter;
    /**
     * @var IStr
     */
    protected $str;


    /**
     * @var IPath
     */
    protected $path;


    /**
     * @var array
     */
    protected $declaredClasses;
    /**
     * @var array
     */
    protected $useStatements;

    /**
     * @var array
     */
    protected $contracts = [];

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
     * @param IFilter $filter
     * @param IStr    $str
     */
    public function __construct(
        IFilter $filter,
        IStr $str
    )
    {
        $this->filter = $filter;
        $this->str = $str;

        $this->reset();
    }


    /**
     * @return static
     */
    public function reset()
    {
        $this->declaredClasses = null;
        $this->useStatements = null;

        $this->contracts = [];

        return $this;
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
     * @param string $class
     *
     * @return array
     */
    protected function loadUseStatements(string $class) : array
    {
        $useStatements = [];

        try {
            $reflectionClass = new \ReflectionClass($class);
        }
        catch ( \ReflectionException $e ) {
            throw new RuntimeException($e->getMessage(), null, $e);
        }

        $code = [];
        $h = fopen($reflectionClass->getFileName(), 'r');
        while ( ! feof($h) ) {
            $line = trim(fgets($h));
            if (! $line) {
                continue;
            }

            if (false
                || ( 0 === mb_stripos($line, $needle = 'class ') )
                || ( 0 === mb_stripos($line, $needle = 'interface ') )
                || ( 0 === mb_stripos($line, $needle = 'trait ') )
                || ( false !== mb_stripos($line, $needle = ' class ') )
                || ( false !== mb_stripos($line, $needle = ' interface ') )
                || ( false !== mb_stripos($line, $needle = ' trait ') )
            ) {
                break;
            }

            $code[] = $line;
        }
        fclose($h);

        $tokens = token_get_all(implode("\n", $code));
        unset($code);

        $use = [];
        $alias = [];
        $isUse = false;
        $isAlias = false;
        foreach ( $tokens as $token ) {
            if (T_USE === $token[ 0 ]) {
                $isUse = true;
                $use = [];

                continue;
            }

            if (T_AS === $token[ 0 ]) {
                $isAlias = true;
                $alias = [];

                continue;
            }

            if ($isAlias) {
                $alias[] = $token[ 1 ];

            } elseif ($isUse) {
                $use[] = $token[ 1 ];
            }

            if (( ';' === $token ) && ( $isUse || $isAlias )) {
                $isUse = false;
                $isAlias = false;

                $use = trim(implode('', $use));
                $alias = trim(implode('', $alias)) ?: $this->className($use);

                $useStatements[ $alias ] = $use;

                $use = [];
                $alias = [];

                continue;
            }
        }

        return $useStatements;
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
     * @param string|object|\ReflectionClass $classOrObject
     *
     * @return array
     */
    public function getUseStatements($classOrObject) : array
    {
        $class = $this->theClassVal($classOrObject);

        return $this->useStatements[ $class ] = $this->useStatements[ $class ]
            ?? $this->loadUseStatements($class);
    }


    /**
     * @return array
     */
    public function getContracts() : array
    {
        return $this->contracts;
    }

    /**
     * @param string $contract
     *
     * @return array
     */
    public function getContract(string $contract) : array
    {
        return $this->contracts[ $contract ];
    }


    /**
     * @param string $contract
     *
     * @return null|array
     */
    public function existsContract($contract) : ?array
    {
        return $this->contracts[ $contract ] ?? null;
    }


    /**
     * @param string       $contract
     * @param string|array $classes
     *
     * @return static
     */
    public function setContract(string $contract, ...$classes)
    {
        $this->contracts[ $contract ] = [];

        $this->addContract($contract, ...$classes);

        return $this;
    }

    /**
     * @param string       $contract
     * @param string|array $classes
     *
     * @return static
     */
    public function addContract(string $contract, ...$classes)
    {
        $contract = $this->str->theWordval($contract);
        $classes = $this->str->theWordvals(...$classes);

        foreach ( $classes as $class ) {
            $class = $this->theClassVal($class);

            if (! ( class_exists($class) || interface_exists($class) )) {
                throw new InvalidArgumentException(
                    [ 'Each Class should be existing ClassName or InterfaceName: %s', $class ]
                );
            }

            $this->contracts[ $contract ][] = $class;
        }

        return $this;
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
     * @return bool
     */
    public function isInstanceOf($value, $classes) : bool
    {
        return null !== $this->filterInstanceOf($value, $classes);
    }

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return bool
     */
    public function isContact($contract, $object) : bool
    {
        return null !== $this->filterContract($contract, $object);
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
     * @param object          $object
     * @param string|string[] $classes
     *
     * @return null|object
     */
    public function filterInstanceOf($object, $classes) : ?object
    {
        $list = $this->str->theWordvals($classes, true);

        foreach ( $list as $class ) {
            if ($object instanceof $class) {
                return $object;
            }
        }

        return null;
    }

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return null|object
     */
    public function filterContract($contract, $object) : ?object
    {
        if (! is_string($contract)) {
            return null;
        }

        if (! is_object($object)) {
            return null;
        }

        $result = $this->filterInstanceOf($object, $this->contracts[ $contract ] ?? []);

        return $result;
    }


    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
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
     * @return string|object
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
     * @param object          $object
     * @param string|string[] ...$classes
     *
     * @return object
     */
    public function assertInstanceOf($object, $classes) : object
    {
        if (null === $this->filterInstanceOf($object, $classes)) {
            throw new InvalidArgumentException('Value should be instance of: '
                . '[' . implode(', ', is_array($classes)
                    ? $classes
                    : [ $classes ]
                ) . ']'
            );
        }

        return $object;
    }

    /**
     * @param string|mixed $contract
     * @param object|mixed $object
     *
     * @return object
     */
    public function assertContract($contract, $object) : object
    {
        if (null === $this->filterContract($contract, $object)) {
            throw new InvalidArgumentException(
                [ 'Object does not match registered contract (%s): %s', $contract, $object ]
            );
        }

        return $object;
    }


    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $prefixed
     *
     * @return null|string
     */
    public function classVal($classOrObject, bool $prefixed = null) : ?string
    {
        $prefixed = $prefixed ?? true;

        $val = null;

        if (null !== ( $class = $this->filter->filterClass($classOrObject) )) {
            $val = $class;

        } elseif (null !== ( $class = $this->objectClassVal($classOrObject) )) {
            $val = $class;
        }

        if (class_exists($val)) {
            if (strlen($val) && $prefixed) {
                $val = '\\' . ltrim($val, '\\');
            }
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $prefixed
     *
     * @return string
     */
    public function theClassVal($classOrObject, bool $prefixed = null) : string
    {
        if (null === ( $val = $this->classVal($classOrObject, $prefixed) )) {
            throw new InvalidArgumentException(
                [ 'Invalid ClassOrObject passed: %s', $classOrObject ]
            );
        }

        return $val;
    }


    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $prefixed
     *
     * @return null|string
     */
    public function objectClassVal($object, bool $prefixed = null) : ?string
    {
        $prefixed = $prefixed ?? true;

        $val = null;

        if (is_object($object)) {
            if (null !== ( $reflectionClass = $this->filter->filterReflectionClass($object) )) {
                $val = $reflectionClass->getName();

            } else {
                $val = get_class($object);
            }
        }

        if (strlen($val) && $prefixed) {
            $val = '\\' . ltrim($val, '\\');
        }

        return $val;
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $prefixed
     *
     * @return string
     */
    public function theObjectClassVal($object, bool $prefixed = null) : string
    {
        if (null === ( $val = $this->objectClassVal($object, $prefixed) )) {
            throw new InvalidArgumentException(
                [ 'Invalid Object passed: %s', $object ]
            );
        }

        return $val;
    }


    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $prefixed
     *
     * @return null|string
     */
    public function useClassVal($classOrObject, $declaredClassOrObject, bool $prefixed = null) : ?string
    {
        $prefixed = $prefixed ?? true;

        if (null === ( $class = $this->classVal($classOrObject, $prefixed) )) {
            return null;
        }

        if (null === ( $declaredClass = $this->classVal($declaredClassOrObject) )) {
            return null;
        }

        if (class_exists($class)) {
            return $class;
        }

        if ('\\' === $class) {
            return $class;
        }

        $val = null;

        $useStatements = $this->getUseStatements($declaredClass);

        [
            $declaredClassNamespace,
            $declaredClassName,
        ] = $this->nsClass($declaredClass);

        $classOrNamespaceAlias = explode('\\', $declaredClassName)[ 0 ];

        $namespace = null
            ?? $useStatements[ $classOrNamespaceAlias ]
            ?? $declaredClassNamespace;

        if (class_exists($class = $namespace . '\\' . $class)) {
            $val = $class;
        }

        if (strlen($val) && $prefixed) {
            $val = '\\' . ltrim($val, '\\');
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $prefixed
     *
     * @return null|string
     */
    public function theUseClassVal($classOrObject, $declaredClassOrObject, bool $prefixed = null) : string
    {
        if (null === ( $val = $this->useClassVal($classOrObject, $declaredClassOrObject, $prefixed) )) {
            throw new InvalidArgumentException(
                [ 'Invalid ClassOrObject passed: %s', $classOrObject ]
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
        $class = $this->theClassVal($classOrObject);

        $class = ltrim($class, '\\');

        if (false !== ( $pos = strrpos($class, '\\') )) {
            $class = substr($class, $pos + 1);
        }

        return $class;
    }


    /**
     * @return \Gzhegow\Support\IPath
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function path() : \Gzhegow\Support\IPath
    {
        if (! isset($this->path)) {
            $this->path = SupportFactory::getInstance()
                ->newPath()
                ->withSeparator('\\')
                ->withDelimiters([ '/' ]);
        }

        return $this->path;
    }


    /**
     * @param string $path
     *
     * @return string
     */
    public function pathOptimize(string $path) : string
    {
        $result = $this->path()->optimize($path);

        return $result;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function pathNormalize(string $path) : string
    {
        $result = $this->path()->normalize($path);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return array
     */
    public function pathSplit(...$parts) : array
    {
        $result = $this->path()->split(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathJoin(...$parts) : string
    {
        $result = $this->path()->join(...$parts);

        return $result;
    }

    /**
     * @param string|string[]|array ...$parts
     *
     * @return string
     */
    public function pathConcat(...$parts) : string
    {
        $result = $this->path()->concat(...$parts);

        return $result;
    }


    /**
     * @param string   $path
     * @param null|int $level
     *
     * @return null|string
     */
    public function pathDirname(string $path, int $level = null) : string
    {
        $result = $this->path()->dirname($path, $level);

        return $result;
    }

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $level
     *
     * @return null|string
     */
    public function pathBasename(string $path, string $suffix = null, int $level = null) : string
    {
        $result = $this->path()->basename($path, $suffix, $level);

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
        if (null === ( $class = $this->classVal($classOrObject, false) )) {
            throw new InvalidArgumentException(
                [ 'Class should be valid class name or object: %s', $classOrObject ]
            );
        }

        $result = $this->path()->relative($class, $base);

        return $result;
    }


    /**
     * @param string $filepath
     * @param array  $data
     *
     * @return mixed
     */
    public function include(string $filepath, array $data = [])
    {
        $this->includeFilepath = $filepath;
        $this->includeData = $data;

        $result = function () {
            extract($this->includeData);

            /** @noinspection PhpIncludeInspection */
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
     */
    public function includeOnce(string $filepath, array $data = [])
    {
        $this->includeFilepath = $filepath;
        $this->includeData = $data;

        $result = function () {
            extract($this->includeData);

            /** @noinspection PhpIncludeInspection */
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
     */
    public function require(string $filepath, array $data = [])
    {
        $this->includeFilepath = $filepath;
        $this->includeData = $data;

        $result = ( function () {
            extract($this->includeData);

            /** @noinspection PhpIncludeInspection */
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
     */
    public function requireOnce(string $filepath, array $data = [])
    {
        $this->includeFilepath = $filepath;
        $this->includeData = $data;

        $result = ( function () {
            extract($this->includeData);

            /** @noinspection PhpIncludeInspection */
            return require_once $this->includeFilepath;
        } );

        $this->includeFilepath = null;
        $this->includeData = [];

        return $result;
    }


    /**
     * @param callable $filter
     * @param null|int $limit
     * @param null|int $offset
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

            if (0 < $offset--) continue;

            $result[] = $class;

            if (isset($limit) && ! $limit--) break;
        }

        return $result;
    }


    /**
     * @return ILoader
     */
    public static function getInstance()
    {
        return SupportFactory::getInstance()->getLoader();
    }
}
