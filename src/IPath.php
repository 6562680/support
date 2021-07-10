<?php

/**
 * This file is auto-generated.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpUnusedAliasInspection
 * @noinspection RedundantSuppression
 */

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

interface IPath
{
    /**
     * @return ZPath
     */
    public function reset();

    /**
     * @param null|string       $separator
     * @param null|string|array $delimiters
     *
     * @return ZPath
     */
    public function clone(?string $separator, ?array $delimiters);

    /**
     * @param null|string       $separator
     * @param null|string|array $delimiters
     *
     * @return ZPath
     */
    public function with(?string $separator, ?array $delimiters);

    /**
     * @param string $separator
     *
     * @return ZPath
     */
    public function withSeparator(string $separator);

    /**
     * @param string[] $delimiters
     *
     * @return ZPath
     */
    public function withDelimiters(array $delimiters);

    /**
     * @return string
     */
    public function getSeparator(): string;

    /**
     * @return string[]
     */
    public function getDelimiters(): array;

    /**
     * @param string $path
     *
     * @return string
     */
    public function optimize(string $path): string;

    /**
     * @param string $path
     *
     * @return string
     */
    public function normalize(string $path): string;

    /**
     * @param string|string[] ...$strvals
     *
     * @return array
     */
    public function split(...$strvals): array;

    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public function join(...$strvals): string;

    /**
     * @param string|string[] ...$strvals
     *
     * @return string
     */
    public function concat(...$strvals): string;

    /**
     * @param string   $path
     * @param null|int $level
     *
     * @return string
     */
    public function dirname(string $path, int $level = null): string;

    /**
     * @param string      $path
     * @param null|string $suffix
     * @param null|int    $level
     *
     * @return string
     */
    public function basename(string $path, string $suffix = null, int $level = null): string;

    /**
     * @param string      $path
     * @param string|null $base
     *
     * @return string
     */
    public function relative(string $path, string $base = null): ?string;

    /**
     * @param string|array ...$strings
     *
     * @return array
     */
    public function protocol(...$strings): array;
}
