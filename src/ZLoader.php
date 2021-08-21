<?php
/**
 * @noinspection RedundantSuppression
 * @noinspection PhpUnusedAliasInspection
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\LogicException;
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
    protected $useStatements = [];

    /**
     * @var array
     */
    protected $contracts = [];


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
        $this->useStatements = [];

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

        foreach ( get_declared_interfaces() as $class ) {
            $map[ '\\' . ltrim($class, '\\') ] = true;
        }

        foreach ( get_declared_traits() as $class ) {
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
        $classes = $this->str->theWordvals($classes, true);

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
    public function isClassOneOf($value, $classes) : bool
    {
        return null !== $this->filterClassOneOf($value, $classes);
    }

    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isSubclassOneOf($value, $classes) : bool
    {
        return null !== $this->filterSubclassOneOf($value, $classes);
    }

    /**
     * @param object          $value
     * @param string|string[] $classes
     *
     * @return bool
     */
    public function isInstanceOneOf($value, $classes) : bool
    {
        return null !== $this->filterInstanceOneOf($value, $classes);
    }


    /**
     * @param string|mixed $object
     * @param object|mixed $contract
     *
     * @return bool
     */
    public function isContract($object, $contract) : bool
    {
        return null !== $this->filterContract($object, $contract);
    }


    /**
     * @param string|object   $value
     * @param string|string[] $classes
     *
     * @return null|string|object
     */
    public function filterClassOneOf($value, $classes) // : ?string|object
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
    public function filterSubclassOneOf($value, $classes) // : ?string|object
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
    public function filterInstanceOneOf($object, $classes) : ?object
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
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return null|object
     */
    public function filterContract($object, $contract) : ?object
    {
        if (! is_object($object)) {
            return null;
        }

        if (! is_string($contract)) {
            return null;
        }

        $result = $this->filterInstanceOneOf($object, $this->contracts[ $contract ] ?? []);

        return $result;
    }


    /**
     * @param string|object   $value
     * @param string|string[] ...$classes
     *
     * @return string|object
     */
    public function assertClassOneOf($value, $classes) // : ?string|object
    {
        if (null === $this->filterClassOneOf($value, $classes)) {
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
    public function assertSubclassOneOf($value, $classes) // : ?string|object
    {
        if (null === $this->filterSubclassOneOf($value, $classes)) {
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
    public function assertInstanceOneOf($object, $classes) : object
    {
        if (null === $this->filterInstanceOneOf($object, $classes)) {
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
     * @param object|mixed $object
     * @param string|mixed $contract
     *
     * @return object
     */
    public function assertContract($object, $contract) : object
    {
        if (null === $this->filterContract($object, $contract)) {
            throw new InvalidArgumentException(
                [ 'Object does not match registered contract (%s): %s', $object, $contract ]
            );
        }

        return $object;
    }


    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public function objectClassVal($object, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        if (is_object($object)) {
            if ($reflectionClass = $this->filter->filterReflectionClass($object)) {
                $val = $reflectionClass->getName();

            } else {
                $val = get_class($object);
            }

            if ($val) {
                $val = $root
                    ? '\\' . ltrim($val, '\\')
                    : ltrim($val, '\\');
            }
        }

        return $val;
    }


    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public function objectClassOnlyVal($object, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        if (is_object($object)) {
            if ($reflectionClass = $this->filter->filterReflectionClass($object)) {
                if (! ( $reflectionClass->isInterface() || $reflectionClass->isTrait() )) {
                    $val = $reflectionClass->getName();
                }

            } else {
                $val = get_class($object);
            }

            if ($val) {
                $val = $root
                    ? '\\' . ltrim($val, '\\')
                    : ltrim($val, '\\');
            }
        }

        return $val;
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public function objectInterfaceOnlyVal($object, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        if (is_object($object)) {
            $reflectionClass = $this->filter->filterReflectionClass($object);

            if ($reflectionClass && $reflectionClass->isInterface()) {
                $val = $reflectionClass->getName();
            }

            if ($val) {
                $val = $root
                    ? '\\' . ltrim($val, '\\')
                    : ltrim($val, '\\');
            }
        }

        return $val;
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return null|string
     */
    public function objectTraitOnlyVal($object, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        if (is_object($object)) {
            $reflectionClass = $this->filter->filterReflectionClass($object);

            if ($reflectionClass && $reflectionClass->isTrait()) {
                $val = $reflectionClass->getName();
            }

            if ($val) {
                $val = $root
                    ? '\\' . ltrim($val, '\\')
                    : ltrim($val, '\\');
            }
        }

        return $val;
    }


    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public function theObjectClassVal($object, bool $root = null) : string
    {
        if (null === ( $val = $this->objectClassOnlyVal($object, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get Class/Interface/Trait Fullname from Object: %s', $object ]
            );
        }

        return $val;
    }


    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public function theObjectClassOnlyVal($object, bool $root = null) : string
    {
        if (null === ( $val = $this->objectClassOnlyVal($object, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get ClassFullname from Object: %s', $object ]
            );
        }

        return $val;
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public function theObjectInterfaceOnlyVal($object, bool $root = null) : string
    {
        if (null === ( $val = $this->objectInterfaceOnlyVal($object, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get InterfaceFullname from Object: %s', $object ]
            );
        }

        return $val;
    }

    /**
     * @param object|\ReflectionClass $object
     * @param null|bool               $root
     *
     * @return string
     */
    public function theObjectTraitOnlyVal($object, bool $root = null) : string
    {
        if (null === ( $val = $this->objectTraitOnlyVal($object, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get TraitFullname from Object: %s', $object ]
            );
        }

        return $val;
    }


    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function classVal($classOrObject, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        if (is_string($classOrObject)) {
            // check class/interface/trait exists
            if (is_a($classOrObject, $classOrObject, true)) {
                $val = $classOrObject;
            }

        } elseif ($class = $this->objectClassOnlyVal($classOrObject, $root)) {
            $val = $class;
        }

        if ($val) {
            $val = $root
                ? '\\' . ltrim($val, '\\')
                : ltrim($val, '\\');
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function classFullnameVal($classOrObject, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        $class = $classOrObject;
        $object = $classOrObject;

        if (is_string($class)) {
            if ($classFullname = $this->filter->filterClassFullname($class)) {
                $val = $classFullname;
            }

        } elseif ($class = $this->objectClassVal($object, $root)) {
            $val = $class;
        }

        if ($val) {
            $val = $root
                ? '\\' . ltrim($val, '\\')
                : ltrim($val, '\\');
        }

        return $val;
    }


    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theClassVal($classOrObject, bool $root = null) : string
    {
        if (null === ( $val = $this->classVal($classOrObject, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get Class/Interface/Trait Fullname from ClassOrObject: %s', $classOrObject ]
            );
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theClassFullnameVal($classOrObject, bool $root = null) : string
    {
        if (null === ( $val = $this->classFullnameVal($classOrObject, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get Class/Interface/Trait Fullname from ClassOrObject: %s', $classOrObject ]
            );
        }

        return $val;
    }


    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function classOnlyVal($classOrObject, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        $class = $classOrObject;
        $object = $classOrObject;

        if (is_string($class) && class_exists($class)) {
            $val = $class;

        } elseif ($class = $this->objectClassOnlyVal($object, $root)) {
            $val = $class;
        }

        if ($val) {
            $val = $root
                ? '\\' . ltrim($val, '\\')
                : ltrim($val, '\\');
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function interfaceOnlyVal($classOrObject, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        $class = $classOrObject;
        $object = $classOrObject;

        if (is_string($class) && interface_exists($class)) {
            $val = $class;

        } elseif ($interface = $this->objectInterfaceOnlyVal($object, $root)) {
            $val = $interface;
        }

        if ($val) {
            $val = $root
                ? '\\' . ltrim($val, '\\')
                : ltrim($val, '\\');
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function traitOnlyVal($classOrObject, bool $root = null) : ?string
    {
        $root = $root ?? true;

        $val = null;

        $class = $classOrObject;
        $object = $classOrObject;

        if (is_string($class) && trait_exists($class)) {
            $val = $class;

        } elseif ($trait = $this->objectTraitOnlyVal($object, $root)) {
            $val = $trait;
        }

        if ($val) {
            $val = $root
                ? '\\' . ltrim($val, '\\')
                : ltrim($val, '\\');
        }

        return $val;
    }


    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theClassOnlyVal($classOrObject, bool $root = null) : string
    {
        if (null === ( $val = $this->classOnlyVal($classOrObject, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get Class Fullname from ClassOrObject: %s', $classOrObject ]
            );
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theInterfaceOnlyVal($classOrObject, bool $root = null) : string
    {
        if (null === ( $val = $this->interfaceOnlyVal($classOrObject, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get Interface Fullname from ClassOrObject: %s', $classOrObject ]
            );
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param null|bool                      $root
     *
     * @return string
     */
    public function theTraitOnlyVal($classOrObject, bool $root = null) : string
    {
        if (null === ( $val = $this->traitOnlyVal($classOrObject, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get Trait Fullname from ClassOrObject: %s', $classOrObject ]
            );
        }

        return $val;
    }


    /**
     * Получает имя класса из списка `use` для указанного `declaredClass`
     *
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function useClassVal($classOrObject, $declaredClassOrObject, bool $root = null) : ?string
    {
        $root = $root ?? true;

        if (null === ( $class = $this->classFullnameVal($classOrObject) )) {
            return null;
        }

        if (null === ( $declaredClass = $this->classVal($declaredClassOrObject) )) {
            return null;
        }

        $val = null;

        $useStatements = $this->getUseStatements($declaredClass);

        $className = $this->className($class);
        if (! isset($useStatements[ $className ])) {
            return null;
        }

        $useClass = null
            ?? $useStatements[ $className ]
            ?? $this->namespace($declaredClass) . '\\' . $className;

        if (class_exists($useClass)) {
            $val = $useClass;
        }

        if ($val && $root) {
            $val = '\\' . ltrim($val, '\\');
        }

        return $val;
    }

    /**
     * @param string|object|\ReflectionClass $classOrObject
     * @param string|object|\ReflectionClass $declaredClassOrObject
     * @param null|bool                      $root
     *
     * @return null|string
     */
    public function theUseClassVal($classOrObject, $declaredClassOrObject, bool $root = null) : string
    {
        if (null === ( $val = $this->useClassVal($classOrObject, $declaredClassOrObject, $root) )) {
            throw new InvalidArgumentException(
                [ 'Unable to get class fullname from class_uses() passed: %s / %s', $classOrObject, $declaredClassOrObject ]
            );
        }

        return $val;
    }


    /**
     * @param string|object $classOrObject
     * @param null|bool     $recursive
     *
     * @return array
     */
    public function classTraits($classOrObject, bool $recursive = null) : ?array
    {
        $recursive = $recursive ?? false;

        if (! $class = $this->classOnlyVal($classOrObject)) {
            return null;
        }

        $results = [];

        $sources = class_parents($class);
        $sources = array_reverse($sources);
        $sources += [ $class => $class ];

        foreach ( $sources as $class ) {
            $results = array_merge($results,
                $this->traitTraits($class, $recursive) ?? []
            );
        }

        $results = array_unique($results);

        return $results;
    }

    /**
     * @param string    $traitFullname
     * @param null|bool $recursive
     *
     * @return array
     */
    public function traitTraits($traitFullname, bool $recursive = null) : ?array
    {
        $recursive = $recursive ?? false;

        if (! $trait = $this->traitOnlyVal($traitFullname)) {
            return null;
        }

        $results = class_uses($trait) ?: [];

        if ($recursive) {
            foreach ( $results as $trait ) {
                $results = array_merge($results,
                    $this->traitTraits($trait, $recursive) ?? []
                );
            }
        }

        $results = array_unique($results);

        return $results;
    }


    /**
     * @param string|object $classOrObject
     *
     * @return string[]
     */
    public function namespaceClass($classOrObject) : array
    {
        $class = $this->theClassFullnameVal($classOrObject);

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
        $class = $this->theClassFullnameVal($classOrObject);

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
        $class = $this->theClassFullnameVal($classOrObject);

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
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public function pathRelative(string $path, string $base = null) : ?string
    {
        $result = $this->path()->relative($path, $base);

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
        // $this
        $result = ( new class( $filepath, $data ) {
            protected $filepath;
            protected $data;

            public function __construct($filepath, $data)
            {
                $this->filepath = $filepath;
                $this->data = $data;
            }

            public function __invoke()
            {
                extract($this->data);

                /** @noinspection PhpIncludeInspection */
                return include $this->filepath;
            }
        } )();

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
        // $this
        $result = ( new class( $filepath, $data ) {
            protected $filepath;
            protected $data;

            public function __construct($filepath, $data)
            {
                $this->filepath = $filepath;
                $this->data = $data;
            }

            public function __invoke()
            {
                static $result;

                extract($this->data);

                /** @noinspection PhpIncludeInspection */
                return $result ?? include_once $this->filepath;
            }
        } )();

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
        // $this
        $result = ( new class( $filepath, $data ) {
            protected $filepath;
            protected $data;

            public function __construct($filepath, $data)
            {
                $this->filepath = $filepath;
                $this->data = $data;
            }

            public function __invoke()
            {
                extract($this->data);

                /** @noinspection PhpIncludeInspection */
                return require $this->filepath;
            }
        } )();

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
        // $this
        $result = ( new class( $filepath, $data ) {
            protected $filepath;
            protected $data;

            public function __construct($filepath, $data)
            {
                $this->filepath = $filepath;
                $this->data = $data;
            }

            public function __invoke()
            {
                static $result;

                extract($this->data);

                /** @noinspection PhpIncludeInspection */
                return $result ?? require_once $this->filepath;
            }
        } )();

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
    public static function getInstance() : ILoader
    {
        return SupportFactory::getInstance()->getLoader();
    }
}
