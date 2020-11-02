<?php

namespace Gzhegow\Support\Stateful;


/**
 * Class Uri
 */
interface UriInterface
{
	/**
	 * @param string $assetPath
	 *
	 * @return Uri
	 */
	public function setAssetPath(string $assetPath);

	/**
	 * @param string $url
	 *
	 * @return array
	 */
	public function linkinfo(string $url) : array;

	/**
	 * @param string|null $query
	 *
	 * @return array
	 */
	public function query(string $query = null) : array;

	/**
	 * @param string|null $url
	 * @param array       $q
	 * @param string|null $ref
	 *
	 * @return string
	 */
	public function path(string $url = null, array $q = [], string $ref = null) : string;

	/**
	 * @param string|null $url
	 * @param array       $q
	 * @param string|null $ref
	 *
	 * @return string
	 */
	public function link(string $url = null, array $q = [], string $ref = null) : string;

	/**
	 * @param string|null $url
	 * @param string|null $ref
	 * @param array       $q
	 *
	 * @return string
	 */
	public function ref(string $url = null, string $ref = null, array $q = []) : string;

	/**
	 * @param string|null $path
	 * @param array       $q
	 *
	 * @return string
	 */
	public function asset(string $path = null, array $q = []) : string;
}