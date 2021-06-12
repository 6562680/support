<?php

namespace Gzhegow\Support\Domain\Str;


/**
 * Slugger
 */
interface SluggerInterface
{
    /**
     * @return null|string
     */
    public function getDefaultLocale() : ?string;

    /**
     * @return array
     */
    public function getSequencesMap() : array;

    /**
     * @return array
     */
    public function getSymbolsMap() : array;


    /**
     * @param array|\Closure $defaultLocale
     *
     * @return static
     */
    public function defaultLocale($defaultLocale);

    /**
     * @param array|\Closure $sequencesMap
     *
     * @return static
     */
    public function sequencesMap($sequencesMap);

    /**
     * @param array|\Closure $symbolsMap
     *
     * @return static
     */
    public function symbolsMap($symbolsMap);


    /**
     * @param string      $string
     * @param null|string $delimiter
     * @param null|string $locale
     *
     * @return string
     */
    public function slug(string $string, string $delimiter = null, string $locale = null) : string;
}
