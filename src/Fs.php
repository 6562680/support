<?php

namespace Gzhegow\Support;

use Gzhegow\Support\Exceptions\Logic\InvalidArgumentException;

/**
 * Class Fs
 */
class Fs
{
	protected function glob(string $pattern, int $flags = null, string $dir = null, bool $multibyte = false) : ?array
	{
		if ('' === $pattern) {
			throw new InvalidArgumentException('Pattern should be not empty', func_get_args());
		}

		if ($dir && ( '' === $dir )) {
			throw new InvalidArgumentException('Dir should be not empty', func_get_args());
		}

		$len = $multibyte
			? mb_strlen($pattern)
			: strlen($pattern);

		$p = '';
		for ( $i = 0; $i < $len; $i++ ) {
			if ($multibyte) {
				$u = mb_strtoupper($pattern[ $i ]);
				$l = mb_strtolower($pattern[ $i ]);

			} else {
				$u = strtoupper($pattern[ $i ]);
				$l = strtolower($pattern[ $i ]);

			}

			if ($u === $l) {
				$p .= $pattern[ $i ];

			} else {
				$p .= "[{$l}{$u}]";

			}
		}

		if ($dir) {
			$p = $dir . DIRECTORY_SEPARATOR . $p;
		}

		$files = glob($p, $flags);

		if (( $flags & GLOB_NOCHECK )
			&& ( ! is_array($files) )
		) {
			return $files;
		}

		if (( ! ( $flags & GLOB_NOSORT ) )
			&& is_array($files)
		) {
			usort($files, function ($a, $b) {
				return is_dir($a) - is_dir($b);
			});
		}

		return $files;
	}
}
