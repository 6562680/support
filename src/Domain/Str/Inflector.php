<?php

namespace Gzhegow\Support\Domain\Str;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Inflector
 */
class Inflector implements InflectorInterface
{
    const DOCTRINE_INFLECTOR          = '\Doctrine\Inflector\Inflector';
    const SYMFONY_INFLECTOR_INTERFACE = '\Symfony\Component\String\Inflector\InflectorInterface';


    /**
     * @var \Doctrine\Inflector\Inflector
     */
    protected $doctrineInflector;
    /**
     * @var \Symfony\Component\String\Inflector\InflectorInterface
     */
    protected $symfonyInflector;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->doctrineInflector();
        $this->symfonyInflector();
    }


    /**
     * @param \Doctrine\Inflector\Inflector $doctrineInflector
     *
     * @return \Doctrine\Inflector\Inflector
     */
    public function doctrineInflector($doctrineInflector = null)
    {
        $commands = [
            'composer require doctrine/inflector',
        ];

        if (func_num_args()) {
            if (isset($doctrineInflector)) {
                if (! class_exists(static::DOCTRINE_INFLECTOR)) {
                    throw new RuntimeException([ 'Please, run following: %s', $commands ]);
                }

                if (! is_a($doctrineInflector, static::DOCTRINE_INFLECTOR)) {
                    throw new RuntimeException([ 'Inflector should implements %s: %s', static::DOCTRINE_INFLECTOR, $doctrineInflector ]);
                }
            }

            $this->doctrineInflector = $doctrineInflector;

        } elseif (! $this->doctrineInflector) {
            if (! class_exists($class = static::DOCTRINE_INFLECTOR)) {
                throw new RuntimeException([ 'Please, run following: %s', $commands ]);
            }

            $cachedWordInflector = '\Doctrine\Inflector\CachedWordInflector';
            $rulesetInflector = '\Doctrine\Inflector\RulesetInflector';
            $englishRules = '\Doctrine\Inflector\Rules\English\Rules';

            $inflector = new $class(
                new $cachedWordInflector(new $rulesetInflector(
                    $englishRules::{'getSingularRuleset'}()
                )),
                new $cachedWordInflector(new $rulesetInflector(
                    $englishRules::{'getPluralRuleset'}()
                ))
            );

            $this->doctrineInflector = $inflector;
        }

        return $this->doctrineInflector;
    }

    /**
     * @param \Symfony\Component\String\Inflector\InflectorInterface $symfonyInflector
     *
     * @return \Symfony\Component\String\Inflector\InflectorInterface
     */
    public function symfonyInflector($symfonyInflector = null)
    {
        $commands = [
            'composer require symfony/string',
        ];

        if (func_num_args()) {
            if (isset($symfonyInflector)) {
                if (! interface_exists(static::SYMFONY_INFLECTOR_INTERFACE)) {
                    throw new RuntimeException([ 'Please, run following: %s', $commands ]);
                }

                if (! is_a($symfonyInflector, static::SYMFONY_INFLECTOR_INTERFACE)) {
                    throw new RuntimeException([ 'Inflector should implements %s: %s', static::SYMFONY_INFLECTOR_INTERFACE, $symfonyInflector ]);
                }
            }

            $this->symfonyInflector = $symfonyInflector;

        } elseif (! $this->symfonyInflector) {
            $engishInflector = '\Symfony\Component\String\Inflector\EnglishInflector';

            if (! class_exists($class = $engishInflector)) {
                throw new RuntimeException([ 'Please, run following: %s', $commands ]);
            }

            $this->symfonyInflector = new $class();
        }

        return $this->symfonyInflector;
    }


    /**
     * @param string   $singular
     * @param null|int $offset
     * @param null|int $limit
     *
     * @return array
     */
    public function pluralize(string $singular, $limit = null, $offset = null) : array
    {
        $array = [];

        $limit = $limit ?? 0;
        $offset = intval($offset ?? 0);

        $array = array_merge($array, $this->pluralizeViaSimpleInflector($singular));

        try {
            $array = array_merge($array, null
                ?? $this->pluralizeViaDoctrineInflector($singular)
                ?? $this->pluralizeViaSymfonyInflector($singular)
            );
        }
        catch ( \Throwable $e ) {
            if (! $array) {
                throw new BadMethodCallException($e->getMessage(), null, $e);
            }
        }

        $array = array_values(array_unique($array));

        $result = [];
        foreach ( $array as $i => $string ) {
            if ($i < $offset) continue;

            $result[ $i ] = $string;

            if (! --$limit) break;
        }

        return $result;
    }

    /**
     * @param string   $plural
     * @param null|int $offset
     * @param null|int $limit
     *
     * @return null|array
     */
    public function singularize(string $plural, $limit = null, $offset = null) : array
    {
        $array = [];

        $limit = $limit ?? 0;
        $offset = intval($offset ?? 0);

        $array = array_merge($array, $this->singularizeViaSimpleInflector($plural));

        try {
            $array = array_merge($array, null
                ?? $this->singularizeViaDoctrineInflector($plural)
                ?? $this->singularizeViaSymfonyInflector($plural)
            );
        }
        catch ( \Throwable $e ) {
            if (! $array) {
                throw new BadMethodCallException($e->getMessage(), null, $e);
            }
        }

        $array = array_values(array_unique($array));

        $result = [];
        foreach ( $array as $i => $string ) {
            if ($i < $offset) continue;

            $result[ $i ] = $string;

            if (! --$limit) break;
        }

        return $result;
    }


    /**
     * @param string $singular
     *
     * @return null|array
     */
    protected function pluralizeViaSimpleInflector(string $singular) : ?array
    {
        $result = [];

        if ('s' === substr($singular, -1)) {
            $string = $singular . 'es';
        } else {
            $string = $singular . 's';
        }

        $result[] = $string;

        return $result;
    }

    /**
     * @param string $plural
     *
     * @return null|array
     */
    protected function singularizeViaSimpleInflector(string $plural) : ?array
    {
        $result = [];

        if ($plural !== ( $string = rtrim($plural, 'sS') )) {
            $result[] = $string;
        }

        return $result;
    }


    /**
     * @param string $singular
     *
     * @return null|array
     */
    protected function pluralizeViaDoctrineInflector(string $singular) : ?array
    {
        if (! class_exists(static::DOCTRINE_INFLECTOR)) {
            return null;
        }

        $result = [];

        if ($this->doctrineInflector) {
            $string = $this->doctrineInflector->{'pluralize'}($singular);

            $result[] = $string;
        }

        return $result;
    }

    /**
     * @param string $plural
     *
     * @return null|array
     */
    protected function singularizeViaDoctrineInflector(string $plural) : ?array
    {
        if (! class_exists(static::DOCTRINE_INFLECTOR)) {
            return null;
        }

        $result = [];

        if ($this->doctrineInflector) {
            $string = $this->doctrineInflector->{'singularize'}($plural);

            $result[] = $string;
        }

        return $result;
    }


    /**
     * @param string $singular
     *
     * @return null|array
     */
    protected function pluralizeViaSymfonyInflector(string $singular) : ?array
    {
        if (! interface_exists(static::SYMFONY_INFLECTOR_INTERFACE)) {
            return null;
        }

        $result = [];

        if ($this->symfonyInflector) {
            $result = $this->symfonyInflector->{'pluralize'}($singular);

            usort($result, function ($a, $b) use ($singular) {
                return similar_text($singular, $b) - similar_text($singular, $a);
            });
        }

        return $result;
    }

    /**
     * @param string $plural
     *
     * @return null|array
     */
    protected function singularizeViaSymfonyInflector(string $plural) : ?array
    {
        if (! interface_exists(static::SYMFONY_INFLECTOR_INTERFACE)) {
            return null;
        }

        $result = [];

        if ($this->symfonyInflector) {
            $result = $this->symfonyInflector->{'singularize'}($plural);

            usort($result, function ($a, $b) use ($plural) {
                return similar_text($plural, $b) - similar_text($plural, $a);
            });
        }

        return $result;
    }
}