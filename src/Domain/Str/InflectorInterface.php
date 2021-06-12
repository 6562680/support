<?php

namespace Gzhegow\Support\Domain\Str;


/**
 * Inflector
 */
interface InflectorInterface
{
    /**
     * @param string   $singular
     * @param null|int $offset
     * @param null|int $limit
     *
     * @return null|string|array
     */
    public function pluralize(string $singular, int $offset = null, int $limit = null);

    /**
     * @param string   $plural
     * @param null|int $offset
     * @param null|int $limit
     *
     * @return null|string|array
     */
    public function singularize(string $plural, int $offset = null, int $limit = null);
}
