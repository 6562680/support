<?php

require_once __DIR__ . '/generator.php';

$generator = new Gzhegow_Support_Generator();


// list
$interfaces = [
    'ArrInterface'      => [ null, \Gzhegow\Support\Arr::class ],
    'CalendarInterface' => [ null, \Gzhegow\Support\Calendar::class ],
    'CliInterface'      => [ null, \Gzhegow\Support\Cli::class ],
    'CmpInterface'      => [ null, \Gzhegow\Support\Cmp::class ],
    'CriteriaInterface' => [ null, \Gzhegow\Support\Criteria::class ],
    'CurlInterface'     => [ null, \Gzhegow\Support\Curl::class ],
    'DebugInterface'    => [ null, \Gzhegow\Support\Debug::class ],
    'EnvInterface'      => [ null, \Gzhegow\Support\Env::class ],
    'FilterInterface'   => [ null, \Gzhegow\Support\Filter::class ],
    'FormatInterface'   => [ null, \Gzhegow\Support\Format::class ],
    'FsInterface'       => [ null, \Gzhegow\Support\Fs::class ],
    'LoaderInterface'   => [ null, \Gzhegow\Support\Loader::class ],
    'MathInterface'     => [ null, \Gzhegow\Support\Math::class ],
    'NetInterface'      => [ null, \Gzhegow\Support\Net::class ],
    'NumInterface'      => [ null, \Gzhegow\Support\Num::class ],
    'PathInterface'     => [ null, \Gzhegow\Support\Path::class ],
    'PhpInterface'      => [ null, \Gzhegow\Support\Php::class ],
    'PregInterface'     => [ null, \Gzhegow\Support\Preg::class ],
    'ProfilerInterface' => [ null, \Gzhegow\Support\Profiler::class ],
    'StrInterface'      => [ null, \Gzhegow\Support\Str::class ],
    'UriInterface'      => [ null, \Gzhegow\Support\Uri::class ],
];

foreach ( $interfaces as $interface => $from ) {
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
    $namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Interfaces');
    $phpFile->addNamespace($namespace);

    $namespace->addUse($originalClass);
    foreach ( $generator->loaderClassUses($fromClass) as $use ) {
        $namespace->addUse($use);
    }

    // class
    $moduleInterface = new \Nette\PhpGenerator\ClassType($interface);
    $moduleInterface->setInterface();

    // copy methods
    $moduleCopy = \Nette\PhpGenerator\ClassType::from($fromClass);
    foreach ( $moduleCopy->getMethods() as $method ) {
        if (! $method->isPublic()) {
            continue;
        }

        $methodName = $method->getName();
        if (null !== $generator->strStarts($methodName, '__')) {
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
        $methodNew->setComment($methodCommentNew);

        $moduleInterface->addMember($methodNew);
    }

    // add to namespace
    $namespace->add($moduleInterface);

    // print
    $content = $printer->printFile($phpFile);

    // store
    $filepath = __ROOT__ . '/src/Interfaces/' . $interface . '.php';

    echo 'Writing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}
