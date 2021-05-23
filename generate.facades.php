<?php

require_once __DIR__ . '/vendor/autoload.php';


$fnStarts = function (string $str, string $needle = null, bool $ignoreCase = true) : ?string {
    $needle = $needle ?? '';

    if ('' === $str) return null;
    if ('' === $needle) return $str;

    $pos = $ignoreCase
        ? mb_stripos($str, $needle)
        : mb_strpos($str, $needle);

    $result = 0 === $pos
        ? mb_substr($str, mb_strlen($needle))
        : null;

    return $result;
};
$fnUses = function (string $class) use ($fnStarts) : array {
    $uses = [];

    /** @noinspection PhpUnhandledExceptionInspection */
    $rc = new \ReflectionClass($class);

    $filepath = $rc->getFileName();

    $h = fopen($filepath, 'r');
    while ( ! feof($h) ) {
        $line = trim(fgets($h));

        if (null !== ( $cut = $fnStarts($line, 'use ') )) {
            $uses[] = rtrim($cut, ';');
        }

        if (null !== $fnStarts($line, 'class ')) {
            break;
        }
    }
    fclose($h);

    return $uses;
};


// list
$facades = [
    'ArrFacade'      => [ null, \Gzhegow\Support\Arr::class ],
    'BcmathFacade'   => [ null, \Gzhegow\Support\Bcmath::class ],
    'CalendarFacade' => [ null, \Gzhegow\Support\Calendar::class ],
    'CliFacade'      => [ null, \Gzhegow\Support\Cli::class ],
    'CmpFacade'      => [ null, \Gzhegow\Support\Cmp::class ],
    'CriteriaFacade' => [ null, \Gzhegow\Support\Criteria::class ],
    'CurlFacade'     => [ null, \Gzhegow\Support\Curl::class ],
    'DebugFacade'    => [ null, \Gzhegow\Support\Debug::class ],
    'EnvFacade'      => [ null, \Gzhegow\Support\Env::class ],
    'FilterFacade'   => [ null, \Gzhegow\Support\Filter::class ],
    'FsFacade'       => [ null, \Gzhegow\Support\Fs::class ],
    'FuncFacade'     => [ null, \Gzhegow\Support\Func::class ],
    'LoaderFacade'   => [ null, \Gzhegow\Support\Loader::class ],
    'MathFacade'     => [ null, \Gzhegow\Support\Math::class ],
    'NetFacade'      => [ null, \Gzhegow\Support\Net::class ],
    'PathFacade'     => [ null, \Gzhegow\Support\Path::class ],
    'PhpFacade'      => [ null, \Gzhegow\Support\Php::class ],
    'PregFacade'     => [ null, \Gzhegow\Support\Preg::class ],
    'ProfilerFacade' => [ null, \Gzhegow\Support\Profiler::class ],
    'StrFacade'      => [ null, \Gzhegow\Support\Str::class ],
    'UriFacade'      => [ null, \Gzhegow\Support\Uri::class ],

    'AssertFacade' => [ \Gzhegow\Support\Generated\GeneratedAssert::class, \Gzhegow\Support\Assert::class ],
    'TypeFacade'   => [ \Gzhegow\Support\Generated\GeneratedType::class, \Gzhegow\Support\Type::class ],
];

foreach ( $facades as $facade => $from ) {
    // original
    [
        $fromClass,
        $originalClass,
    ] = $from + [ null, null ];
    $fromClass = $fromClass ?? $originalClass;
    $originalClassName = substr($originalClass, strrpos($originalClass, '\\') + 1);


    // printer
    $printer = new \Nette\PhpGenerator\PsrPrinter();

    // file
    $phpFile = new \Nette\PhpGenerator\PhpFile();
    $phpFile->setComment(implode("\n", [
        'This file is auto-generated.',
        '',
        '@noinspection PhpDocMissingThrowsInspection',
        '@noinspection PhpUnhandledExceptionInspection',
        '@noinspection PhpUnusedAliasInspection',
    ]));

    // namespace
    $namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Facades\\Generated');
    $phpFile->addNamespace($namespace);

    $namespace->addUse($originalClass);
    foreach ( $fnUses($fromClass) as $use ) {
        $namespace->addUse($use);
    }

    // class
    $moduleFacade = new \Nette\PhpGenerator\ClassType('Generated' . $facade);
    $moduleFacade->setAbstract();

    // copy methods
    $moduleCopy = \Nette\PhpGenerator\ClassType::from($fromClass);
    foreach ( $moduleCopy->getMethods() as $method ) {
        if (! $method->isPublic()) {
            continue;
        }

        $methodName = $method->getName();
        if (null !== $fnStarts($methodName, '__')) {
            continue;
        }

        $methodParameters = $method->getParameters();
        $methodComment = $method->getComment();
        $methodReturnType = $method->getReturnType();

        $arguments = [];
        $parameters = $method->getParameters();
        $last = array_pop($parameters);
        foreach ( $parameters as $parameter ) {
            $arguments[] = '$' . $parameter->getName();
        }
        if ($last) {
            $arguments[] = $method->isVariadic()
                ? '...$' . $last->getName()
                : '$' . $last->getName();
        }

        $lines = explode("\n", $methodComment);
        foreach ( $lines as $i => $line ) {
            if (false !== mb_strpos($line, $separator = '@return static')) {
                $parts = explode($separator, $line);

                $lines[ $i ] = implode('@return ' . $originalClassName, $parts);
            }
        }
        $methodCommentNew = implode("\n", $lines);

        $return = null
            ?? ( $methodReturnType === 'void' ? '' : null )
            ?? ( $methodReturnType === \Generator::class ? 'yield from ' : null )
            ?? 'return ';

        $methodNew = new \Nette\PhpGenerator\Method($methodName);
        $methodNew->setVariadic($method->isVariadic());
        $methodNew->setReturnNullable($method->isReturnNullable());
        $methodNew->setParameters($methodParameters);
        $methodNew->setReturnType($methodReturnType);
        $methodNew->setPublic();
        $methodNew->setStatic();
        $methodNew->setComment($methodCommentNew);
        $methodNew->setBody(implode("\n", [
            sprintf(
                $return . 'static::getInstance()->' . $methodName . '(%s);',
                implode(', ', $arguments),
            ),
        ]));

        $moduleFacade->addMember($methodNew);
    }

    // add methods
    $method = new \Nette\PhpGenerator\Method('getInstance');
    $method->setAbstract();
    $method->setPublic();
    $method->setStatic();
    $method->setReturnType($originalClass);
    $method->setComment(implode("\n", [
        '@return ' . $originalClassName,
    ]));
    $moduleFacade->addMember($method);

    // add to namespace
    $namespace->add($moduleFacade);

    // print
    $content = $printer->printFile($phpFile);

    // store
    $filepath = __DIR__ . '/src/Facades/Generated/Generated' . $facade . '.php';

    echo 'Writing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}
