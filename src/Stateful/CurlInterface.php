<?php

namespace Gzhegow\Support\Stateful;


/**
 * Class Curl
 */
interface CurlInterface
{
	/**
	 * готовит инструкцию для curl запоса и сохраняет матрицу для создания на основе
	 * если передать готовый curl запрос заменит существующие опции
	 * если создавали через эту же функцию, опции будут соединены с предыдущим экземпляром, иначе переписаны
	 *
	 * @param mixed $curl
	 * @param null  $data
	 * @param array $curl_options
	 *
	 * @return resource
	 */
	public function createNew($curl, $data = null, array $curl_options = []);

	/**
	 * копирует или создает curl запрос и сохраняет матрицу для создания на основе
	 * если передать готовый curl запрос заменит существующие опции и вернет новый curl
	 * если создавали через эту же функцию, опции будут соединены с предыдущим экземпляром, иначе переписаны
	 *
	 * @param mixed $curl
	 * @param mixed $data
	 * @param array $curl_options
	 *
	 * @return resource
	 */
	public function createCopy($curl, $data = null, array $curl_options = []);

	/**
	 * @return array
	 */
	public function getOptionsDefault() : array;

	/**
	 * @param mixed $h
	 *
	 * @return boolean
	 */
	public function isCurl($h) : bool;

	/**
	 * @param resource $h
	 * @param int|null $opt
	 * @param null     $getinfo
	 *
	 * @return boolean
	 */
	public function isOpenedCurl($h, $opt = null, &$getinfo = null) : bool;

	/**
	 * @param string|int $option
	 * @param mixed      $value
	 *
	 * @return Curl
	 */
	public function setOptionDefault($option, $value);

	/**
	 * @param array $options
	 *
	 * @return Curl
	 */
	public function setOptionsDefault(array $options);

	/**
	 * @param array $options
	 *
	 * @return Curl
	 */
	public function mergeOptionsDefault(array $options);

	/**
	 * возвращает результат curl_getinfo
	 *
	 * @param mixed $curl
	 * @param mixed $opt
	 *
	 * @return mixed
	 */
	public function info($curl, $opt = null);

	/**
	 * возвращает результат curl_getinfo. работает с массивом ресурсов
	 *
	 * @param array $curls
	 * @param null  $opt
	 *
	 * @return array
	 */
	public function infos(array $curls, $opt = null) : array;

	/**
	 * выводит список сохраненных опций, по которым будет создаваться новый ресурс при копировании или обновлении
	 *
	 * @param mixed $curl
	 * @param bool  $verbose
	 *
	 * @return array
	 */
	public function opt($curl, bool $verbose = false) : array;

	/**
	 * выводит список сохраненных опций, по которым будет создаваться новый ресурс при копировании или обновлении. работает с массивом ресурсов
	 *
	 * @param array $curls
	 * @param bool  $verbose
	 *
	 * @return array
	 */
	public function opts(array $curls, bool $verbose = false) : array;

	/**
	 * делает запросы группами по $limit, с задержкой между группами в $sleep секунд
	 * если параметр $urls передан как обьект, то обработка результатов должна быть генератором
	 *
	 * @param mixed $limit
	 * @param mixed $sleep
	 * @param mixed $curls
	 * @param null  $post
	 * @param array $options
	 *
	 * @return array
	 */
	public function batch($limit, $sleep, $curls, $post = null, array $options = []) : array;

	/**
	 * @param mixed $limit
	 * @param mixed $sleep
	 * @param mixed $curls
	 * @param null  $post
	 * @param array $options
	 *
	 * @return \Generator
	 */
	public function walk($limit, $sleep, $curls, $post = null, array $options = []) : \Generator;

	/**
	 * делает параллельный (одновременный) запрос через curl
	 *
	 * @param mixed $curls
	 * @param null  $post
	 * @param array $options
	 *
	 * @return array
	 */
	public function multi($curls, $post = null, array $options = []) : array;
}