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

use Gzhegow\Support\Traits\Load\StrLoadTrait;

interface IPath
{
    /**
     * @param null|string $separator
     *
     * @return XPath
     */
    public function withSeparator(?string $separator);

    /**
     * @param null|string[] $separatorAliases
     *
     * @return XPath
     */
    public function withSeparatorAliases(?array $separatorAliases);

    /**
     * @return string
     */
    public function loadSeparator(): string;

    /**
     * @return string[]
     */
    public function loadSeparatorAliases(): array;

    /**
     * @return string
     */
    public function getSeparator(): string;

    /**
     * @return string[]
     */
    public function getSeparatorAliases(): array;

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
     * @param string|string[] ...$strings
     *
     * @return array
     */
    public function split(...$strings): array;

    /**
     * @param string|string[] ...$strings
     *
     * @return string
     */
    public function join(...$strings): string;

    /**
     * @param string|string[] ...$strings
     *
     * @return string
     */
    public function concat(...$strings): string;

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
