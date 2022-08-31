<?php

require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator_FacadeGenerator();

$theStr = $generator->getStr();
$theLoader = $generator->getLoader();


// list
$facades = [
    'Arr'       => [ \Gzhegow\Support\IArr::class, \Gzhegow\Support\XArr::class ],
    'Cache'     => [ \Gzhegow\Support\ICache::class, \Gzhegow\Support\XCache::class ],
    'Calendar'  => [ \Gzhegow\Support\ICalendar::class, \Gzhegow\Support\XCalendar::class ],
    'Cli'       => [ \Gzhegow\Support\ICli::class, \Gzhegow\Support\XCli::class ],
    'Cmp'       => [ \Gzhegow\Support\ICmp::class, \Gzhegow\Support\XCmp::class ],
    'Criteria'  => [ \Gzhegow\Support\ICriteria::class, \Gzhegow\Support\XCriteria::class ],
    'Curl'      => [ \Gzhegow\Support\ICurl::class, \Gzhegow\Support\XCurl::class ],
    'Debug'     => [ \Gzhegow\Support\IDebug::class, \Gzhegow\Support\XDebug::class ],
    'Env'       => [ \Gzhegow\Support\IEnv::class, \Gzhegow\Support\XEnv::class ],
    'Filter'    => [ \Gzhegow\Support\IFilter::class, \Gzhegow\Support\XFilter::class ],
    'Format'    => [ \Gzhegow\Support\IFormat::class, \Gzhegow\Support\XFormat::class ],
    'Fs'        => [ \Gzhegow\Support\IFs::class, \Gzhegow\Support\XFs::class ],
    'Itertools' => [ \Gzhegow\Support\IItertools::class, \Gzhegow\Support\XItertools::class ],
    'Loader'    => [ \Gzhegow\Support\ILoader::class, \Gzhegow\Support\XLoader::class ],
    'Logger'    => [ \Gzhegow\Support\ILogger::class, \Gzhegow\Support\XLogger::class ],
    'Math'      => [ \Gzhegow\Support\IMath::class, \Gzhegow\Support\XMath::class ],
    'Net'       => [ \Gzhegow\Support\INet::class, \Gzhegow\Support\XNet::class ],
    'Num'       => [ \Gzhegow\Support\INum::class, \Gzhegow\Support\XNum::class ],
    'Path'      => [ \Gzhegow\Support\IPath::class, \Gzhegow\Support\XPath::class ],
    'Php'       => [ \Gzhegow\Support\IPhp::class, \Gzhegow\Support\XPhp::class ],
    'Prof'      => [ \Gzhegow\Support\IProf::class, \Gzhegow\Support\XProf::class ],
    'Str'       => [ \Gzhegow\Support\IStr::class, \Gzhegow\Support\XStr::class ],
    'Uri'       => [ \Gzhegow\Support\IUri::class, \Gzhegow\Support\XUri::class ],
];

// deps
$printer = new \Nette\PhpGenerator\PsrPrinter();

foreach ( $facades as $facade => [ $sourceInterface, $sourceClass ] ) {
    // vars
    $filepath = __ROOT__ . '/src/Facades/' . $facade . '.php';

    // original
    $sourceClassName = substr($sourceClass, strrpos($sourceClass, '\\') + 1);

    // file
    $phpFile = new \Nette\PhpGenerator\PhpFile();
    $phpFile->setComment(implode("\n", [
        'This file is auto-generated.',
        '',
        '@noinspection PhpDocMissingThrowsInspection',
        '@noinspection PhpUnhandledExceptionInspection',
        '@noinspection PhpUnusedAliasInspection',
        '@noinspection RedundantSuppression',
    ]));

    // namespace
    $phpNamespace = new \Nette\PhpGenerator\PhpNamespace($namespace = 'Gzhegow\\Support\\Facades');

    // class
    $classTypeFacade = new \Nette\PhpGenerator\ClassType($facade);

    // add uses
    $phpNamespace->addUse(\Gzhegow\Support\SupportFactory::class);
    $phpNamespace->addUse($sourceInterface);

    // copy uses/methods
    $classTypeSource = \Nette\PhpGenerator\ClassType::from($sourceClass, false, false);

    $sourceUses = [ $theLoader->getUseStatements($sourceClass) ];
    $sourceMethods = [ $generator->filterMethods($classTypeSource->getMethods()) ];
    $classTypeCurrent = $classTypeSource;
    while ( $current = $classTypeCurrent->getExtends() ) {
        $classTypeCurrent = \Nette\PhpGenerator\ClassType::from($current, false, false);

        $sourceUses[] = $theLoader->getUseStatements($current);
        $sourceMethods[] = $generator->filterMethods($classTypeCurrent->getMethods());
    }
    $sourceUses = array_merge(...$sourceUses);
    $sourceMethods = array_merge(...$sourceMethods);

    // copy uses
    $phpNamespace->addUse($sourceClass);
    foreach ( $sourceUses as $alias => $use ) {
        $phpNamespace->addUse($use, $alias);
    }

    // copy methods
    foreach ( $sourceMethods as $sourceMethod ) {
        $methodName = $sourceMethod->getName();

        $arguments = [];
        $parameters = $sourceMethod->getParameters();
        $last = array_pop($parameters);
        foreach ( $parameters as $parameter ) {
            $arguments[] = '$' . $parameter->getName();
        }
        if ($last) {
            $arguments[] = $sourceMethod->isVariadic()
                ? '...$' . $last->getName()
                : '$' . $last->getName();
        }

        $lines = explode("\n", $sourceMethod->getComment());
        foreach ( $lines as $i => $line ) {
            if (false !== mb_strpos($line, $separator = '@return static')) {
                $parts = explode($separator, $line);

                $lines[ $i ] = implode('@return ' . $sourceClassName, $parts);
            }
        }
        $methodCommentNew = implode("\n", $lines);

        $methodNew = new \Nette\PhpGenerator\Method($methodName);
        $methodNew->setStatic();
        $methodNew->setPublic();
        $methodNew->setParameters($sourceMethod->getParameters());
        $methodNew->setVariadic($sourceMethod->isVariadic());
        $methodNew->setReturnType($sourceMethod->getReturnType());
        $methodNew->setReturnNullable($sourceMethod->isReturnNullable());
        $methodNew->setReturnReference($sourceMethod->getReturnReference());
        $methodNew->setComment($methodCommentNew);
        $methodNew->setBody(
            $generator->generateMethodBody(
                $sourceMethod,
                $methodName, $arguments
            )
        );

        $classTypeFacade->addMember($methodNew);
    }

    // add methods
    $sourceMethod = new \Nette\PhpGenerator\Method('getInstance');
    $sourceMethod->setPublic();
    $sourceMethod->setStatic();
    $sourceMethod->setReturnType($sourceInterface);
    $sourceMethod->setComment(implode("\n", [
        '@return ' . substr($sourceInterface, strrpos($sourceInterface, '\\') + 1),
    ]));
    $sourceMethod->setBody(implode("\n", [
        sprintf('return SupportFactory::getInstance()->get%s();', $facade),
    ]));
    $classTypeFacade->addMember($sourceMethod);

    // add classType to namespace
    $phpNamespace->add($classTypeFacade);

    // add phpNamespace to phpFile
    $phpFile->addNamespace($phpNamespace);

    // print
    $content = $printer->printFile($phpFile);

    // store
    echo 'Writing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}