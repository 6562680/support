<?php

namespace Gzhegow\Support\Domain\Str;

use Gzhegow\Support\Exceptions\RuntimeException;
use Gzhegow\Support\Exceptions\Logic\BadMethodCallException;


/**
 * Inflector
 */
class Inflector implements InflectorInterface
{
    const SYMFONY_ENGLISH_INFLECTOR   = '\Symfony\Component\String\Inflector\EnglishInflector';
    const SYMFONY_INFLECTOR_INTERFACE = '\Symfony\Component\String\Inflector\InflectorInterface';


    /**
     * @var \Symfony\Component\String\Inflector\InflectorInterface $symfonyInflector
     */
    protected $symfonyInflector;


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

        if ($symfonyInflector) {
            if (! interface_exists(static::SYMFONY_INFLECTOR_INTERFACE)) {
                throw new RuntimeException([ 'Please, run following: %s', $commands ]);
            }

            if (! is_a($symfonyInflector, static::SYMFONY_INFLECTOR_INTERFACE)) {
                throw new RuntimeException([ 'Slugger should implements %s: %s', static::SYMFONY_INFLECTOR_INTERFACE, $symfonyInflector ]);
            }

            $this->symfonyInflector = $symfonyInflector;
        }

        if (! $this->symfonyInflector) {
            if (! class_exists($class = static::SYMFONY_ENGLISH_INFLECTOR)) {
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
        $result = [];

        try {
            $result = $this->pluralizeSymfonyInflector($singular, $limit, $offset);
        }
        catch ( \Throwable $e ) {
            throw new BadMethodCallException($e->getMessage(), null, $e);
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
        $result = [];

        try {
            $result = $this->singularizeSymfonyInflector($plural, $limit, $offset);
        }
        catch ( \Throwable $e ) {
            throw new BadMethodCallException($e->getMessage(), null, $e);
        }

        return $result;
    }


    /**
     * @param string   $singular
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return null|array
     */
    protected function pluralizeSymfonyInflector(string $singular, $limit = null, $offset = null) : ?array
    {
        if (! interface_exists(static::SYMFONY_INFLECTOR_INTERFACE)) {
            return null;
        }

        $limit = $limit ?? 0;
        $offset = intval($offset ?? 0);

        $array = $this->symfonyInflector()->{'pluralize'}($singular);

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
    protected function singularizeSymfonyInflector(string $plural, $limit = null, $offset = 0) : ?array
    {
        if (! interface_exists(static::SYMFONY_INFLECTOR_INTERFACE)) {
            return null;
        }

        $limit = $limit ?? 0;
        $offset = intval($offset ?? 0);

        $array = $this->symfonyInflector()->{'singularize'}($plural);

        $result = [];
        foreach ( $array as $i => $string ) {
            if ($i < $offset) continue;

            $result[ $i ] = $string;

            if (! --$limit) break;
        }

        return $result;
    }
}
