<?php

namespace Gzhegow\Support\Domain\Str;


/**
 * Inflector
 */
interface InflectorInterface
{
    /**
     * @param string   $singular
     * @param null|int $limit
     * @param int      $offset
     *
     * @return null|string|array
     */
    public function pluralize(string $singular, $limit = null, $offset = 0);

    /**
     * @param string   $plural
     * @param null|int $limit
     * @param int      $offset
     *
     * @return null|string|array
     */
    public function singularize(string $plural, $limit = null, $offset = 0);
}
