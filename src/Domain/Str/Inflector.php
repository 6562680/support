<?php

namespace Gzhegow\Support\Domain\Str;

use Gzhegow\Support\Exceptions\RuntimeException;


/**
 * Inflector
 */
class Inflector implements InflectorInterface
{
    /**
     * @var \Symfony\Component\String\Inflector\InflectorInterface $symfonyInflector
     */
    protected $symfonyInflector;


    /**
     * @param null|\Symfony\Component\String\Slugger\SluggerInterface $symfonyInflector
     *
     * @return \Symfony\Component\String\Slugger\SluggerInterface
     */
    public function symfonyInflector($symfonyInflector = null)
    {
        $commands = [
            'composer require symfony/string',
        ];

        if ($symfonyInflector) {
            if (! interface_exists($interface = 'Symfony\Component\String\Inflector\InflectorInterface')) {
                throw new RuntimeException([ 'Please, run following: %s', $commands ]);
            }

            if (! is_a($symfonyInflector, $interface)) {
                throw new RuntimeException([ 'Slugger should implements %s: %s', $interface, $symfonyInflector ]);
            }

            $this->symfonyInflector = $symfonyInflector;
        }

        if (! $this->symfonyInflector) {
            if (! class_exists($class = 'Symfony\Component\String\Inflector\EnglishInflector')) {
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
     * @return null|string|array
     */
    public function pluralize(string $singular, int $offset = null, int $limit = null) // : ?string|array
    {
        $result = null;

        try {
            $result = $this->pluralizeSymfonyInflector($singular, $offset, $limit);
        }
        catch ( \Throwable $e ) {
        }

        return $result;
    }

    /**
     * @param string   $plural
     * @param null|int $offset
     * @param null|int $limit
     *
     * @return null|string|array
     */
    public function singularize(string $plural, int $offset = null, int $limit = null) // : ?string|array
    {
        $result = null;

        try {
            $result = $this->singularizeSymfonyInflector($plural, $offset, $limit);
        }
        catch ( \Throwable $e ) {
        }

        return $result;
    }


    /**
     * @param string   $singular
     * @param null|int $offset
     * @param null|int $limit
     *
     * @return null|string
     */
    protected function pluralizeSymfonyInflector(string $singular, int $offset = null, int $limit = null) // : string|array
    {
        if (! interface_exists($interface = 'Symfony\Component\String\Inflector\InflectorInterface')) {
            return null;
        }

        $result = $this->symfonyInflector()->pluralize($singular);

        $result = null
            ?? ( isset($limit) ? array_slice($result, max(0, $offset ?? 0), $limit) : null )
            ?? ( isset($offset) ? $result[ $offset ?? 0 ] : null )
            ?? $result;

        return $result;
    }

    /**
     * @param string   $plural
     * @param null|int $offset
     * @param null|int $limit
     *
     * @return null|string|array
     */
    protected function singularizeSymfonyInflector(string $plural, int $offset = null, int $limit = null) // : string|array
    {
        if (! interface_exists($interface = 'Symfony\Component\String\Inflector\InflectorInterface')) {
            return null;
        }

        $result = $this->symfonyInflector()->singularize($plural);

        $result = null
            ?? ( isset($limit) ? array_slice($result, max(0, $offset ?? 0), $limit) : null )
            ?? ( isset($offset) ? $result[ $offset ?? 0 ] : null )
            ?? $result;

        return $result;
    }
}
