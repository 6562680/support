<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Stateful\Curl;
use Gzhegow\Support\Stateful\CurlInterface;
use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Net
 */
class Net
{
	/**
	 * @var Curl
	 */
	protected $curl;
	/**
	 * @var Str
	 */
	protected $str;


	/**
	 * Constructor
	 *
	 * @param Curl $curl
	 * @param Str  $str
	 */
	public function __construct(CurlInterface $curl, Str $str)
	{
		$this->curl = $curl;
		$this->str = $str;
	}


	/**
	 * @param string $ip
	 *
	 * @return bool
	 */
	public function isIp(string $ip) : bool
	{
		if ('' === $ip) return false;

		return filter_var($ip, FILTER_VALIDATE_IP);
	}

	/**
	 * @param string $mask
	 * @param null   $subnet_ip
	 * @param null   $cidr
	 *
	 * @return bool
	 */
	public function isMask(string $mask, &$subnet_ip = null, &$cidr = null) : bool
	{
		if ('' === $mask) return false;

		[ $subnet_ip, $cidr ] = explode('/', $mask) + [ null, 32 ];

		$cidr = (int) $cidr;
		if ($cidr < 0) return false;
		if ($cidr > 32) return false;

		return true;
	}


	/**
	 * @param string $ip
	 * @param string $mask
	 *
	 * @return bool
	 */
	public function isInSubnet(string $ip, string $mask) : bool
	{
		if (! $this->isIp($ip)) return false;
		if (! $this->isMask($mask, $subnet_ip, $cidr)) return true;

		$bitmask = -1 << 32 - $cidr;

		return ( ip2long($ip) & $bitmask ) === ( ip2long($subnet_ip) & $bitmask );
	}


	/**
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function get(string $url, $data = null, array $headers = []) : array
	{
		return $this->request('GET', $url, $data, $headers);
	}


	/**
	 * @param string $header
	 *
	 * @return null|string
	 */
	public function header(string $header) : ?string
	{
		if ('' === $header) {
			return null;
		}

		$server_key = $this->str->prepend(strtoupper($this->str->snake($header)), 'HTTP_');

		$result = null
			?? $_SERVER[ $server_key ]
			?? $this->headers()[ $header ]
			?? null;

		return $result;
	}

	/**
	 * @return array
	 */
	public function headers() : array
	{
		$result = [];

		foreach ( $_SERVER as $key => $val ) {
			if (! $header = $this->str->starts($key, 'HTTP_')) continue;

			$result[ $this->str->usnake($header, $delimiter = '-') ] = $val;
		}

		return $result;
	}


	/**
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function head(string $url, $data = null, array $headers = []) : array
	{
		return $this->request('HEAD', $url, $data, $headers);
	}


	/**
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function options(string $url, $data = null, array $headers = []) : array
	{
		return $this->request('OPTIONS', $url, $data, $headers);
	}


	/**
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function post(string $url, $data = null, array $headers = []) : array
	{
		return $this->request('POST', $url, $data, $headers);
	}

	/**
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function patch(string $url, $data = null, array $headers = []) : array
	{
		return $this->request('PATCH', $url, $data, $headers);
	}

	/**
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function put(string $url, $data = null, array $headers = []) : array
	{
		return $this->request('PUT', $url, $data, $headers);
	}

	/**
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function delete(string $url, $data = null, array $headers = []) : array
	{
		return $this->request('DELETE', $url, $data, $headers);
	}

	/**
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function purge(string $url, $data = null, array $headers = []) : array
	{
		return $this->request('PURGE', $url, $data, $headers);
	}


	/**
	 * @param string $method
	 * @param string $url
	 * @param mixed  $data
	 * @param array  $headers
	 *
	 * @return array
	 */
	public function request(string $method, string $url, $data = null, array $headers = []) : array
	{
		switch ( strtoupper($method) ):
			case $var = 'HEAD':
			case $var = 'OPTIONS':
			case $var = 'GET':
			case $var = 'POST':
			case $var = 'PATCH':
			case $var = 'PUT':
			case $var = 'DELETE':
			case $var = 'PURGE':
			case $var = 'CONNECT':
			case $var = 'TRACE':
				$method = $var;
				break;

			default:
				throw new InvalidArgumentException('Method is not supported: ' . $method);

		endswitch;

		if (false === filter_var($url, FILTER_VALIDATE_URL)) {
			throw new InvalidArgumentException('Incorrect url passed: ' . $url);
		}

		// type
		$options[ CURLOPT_CUSTOMREQUEST ] = $method;

		// headers
		foreach ( $headers as $key => $val ) {
			$options[ CURLOPT_HTTPHEADER ][] = $key . ': ' . $val;
		}

		// handle HEAD request
		if ('HEAD' === $method) {
			$options[ CURLOPT_NOBODY ] = true;
		}

		// build
		$handler = $this->curl->createNew($url, $data, $options);

		// execute
		$content = curl_exec($handler);

		return [ $content, $handler ];
	}


	/**
	 * @return string
	 */
	public function ip() : string
	{
		return null
			?? $_SERVER[ 'HTTP_CLIENT_IP' ]
			?? $_SERVER[ 'HTTP_X_FORWARDED_FOR' ]
			?? $_SERVER[ 'REMOTE_ADDR' ]
			?? '127.0.0.1';
	}

	/**
	 * @return null|string
	 */
	public function useragent() : ?string
	{
		return isset($_SERVER[ 'HTTP_USER_AGENT' ])
			? $_SERVER[ 'HTTP_USER_AGENT' ]
			: null;
	}
}
