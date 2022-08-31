<?php

require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator();

$theStr = $generator->getStr();
$theLoader = $generator->getLoader();


// list
$interfaces = [
    'IArr'       => [ \Gzhegow\Support\XArr::class ],
    'ICache'     => [ \Gzhegow\Support\XCache::class ],
    'ICalendar'  => [ \Gzhegow\Support\XCalendar::class ],
    'ICli'       => [ \Gzhegow\Support\XCli::class ],
    'ICmp'       => [ \Gzhegow\Support\XCmp::class ],
    'ICriteria'  => [ \Gzhegow\Support\XCriteria::class ],
    'ICurl'      => [ \Gzhegow\Support\XCurl::class ],
    'IDebug'     => [ \Gzhegow\Support\XDebug::class ],
    'IEnv'       => [ \Gzhegow\Support\XEnv::class ],
    'IFilter'    => [ \Gzhegow\Support\XFilter::class ],
    'IFormat'    => [ \Gzhegow\Support\XFormat::class ],
    'IFs'        => [ \Gzhegow\Support\XFs::class ],
    'IItertools' => [ \Gzhegow\Support\XItertools::class ],
    'ILoader'    => [ \Gzhegow\Support\XLoader::class ],
    'ILogger'    => [ \Gzhegow\Support\XLogger::class ],
    'IMath'      => [ \Gzhegow\Support\XMath::class ],
    'INet'       => [ \Gzhegow\Support\XNet::class ],
    'INum'       => [ \Gzhegow\Support\XNum::class ],
    'IPath'      => [ \Gzhegow\Support\XPath::class ],
    'IPhp'       => [ \Gzhegow\Support\XPhp::class ],
    'IProf'      => [ \Gzhegow\Support\XProf::class ],
    'IStr'       => [ \Gzhegow\Support\XStr::class ],
    'IUri'       => [ \Gzhegow\Support\XUri::class ],
];

// deps
$printer = new \Nette\PhpGenerator\PsrPrinter();

foreach ( $interfaces as $interface => $sourceClasses ) {
    // vars
    $filepath = __ROOT__ . '/src/' . $interface . '.php';

    // original
    $originalClass = reset($sourceClasses);
    $originalClassName = substr($originalClass, strrpos($originalClass, '\\') + 1);

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
    $phpNamespace = new \Nette\PhpGenerator\PhpNamespace($namespace = 'Gzhegow\\Support');

    // class
    $classTypeInterface = new \Nette\PhpGenerator\ClassType($interface);
    $classTypeInterface->setInterface();

    // copy uses/methods
    foreach ( $sourceClasses as $sourceClass ) {
        $classTypeSource = \Nette\PhpGenerator\ClassType::from($sourceClass, false, false);

        $uses = [ $theLoader->getUseStatements($sourceClass) ];
        $sourceMethods = [ $generator->filterMethods($classTypeSource->getMethods()) ];
        $classTypeCurrent = $classTypeSource;
        while ( $current = $classTypeCurrent->getExtends() ) {
            $classTypeCurrent = \Nette\PhpGenerator\ClassType::from($current, false, false);

            $uses[] = $theLoader->getUseStatements($current);
            $sourceMethods[] = $generator->filterMethods($classTypeCurrent->getMethods());
        }
        $uses = array_merge(...$uses);
        $sourceMethods = array_merge(...$sourceMethods);

        // copy uses
        $phpNamespace->addUse($sourceClass);
        foreach ( $uses as $alias => $use ) {
            if ($use === $namespace . '\\' . $interface) {
                continue;
            }

            $phpNamespace->addUse($use, $alias);
        }

        // copy methods
        foreach ( $sourceMethods as $sourceMethod ) {
            $methodName = $sourceMethod->getName();

            $methodParameters = $sourceMethod->getParameters();
            $methodComment = $sourceMethod->getComment();
            $methodReturnType = $sourceMethod->getReturnType();

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

            $lines = explode("\n", $methodComment);
            foreach ( $lines as $i => $line ) {
                if (false !== mb_strpos($line, $separator = '@return static')) {
                    $parts = explode($separator, $line);

                    $lines[ $i ] = implode('@return ' . $originalClassName, $parts);
                }
            }
            $methodCommentNew = implode("\n", $lines);

            $methodNew = new \Nette\PhpGenerator\Method($methodName);
            $methodNew->setReturnNullable($sourceMethod->isReturnNullable());
            $methodNew->setReturnReference($sourceMethod->getReturnReference());
            $methodNew->setVariadic($sourceMethod->isVariadic());
            $methodNew->setParameters($methodParameters);
            $methodNew->setReturnType($methodReturnType);
            $methodNew->setPublic();
            $methodNew->setComment($methodCommentNew);

            $classTypeInterface->addMember($methodNew);
        }
    }

    // add interface to namespace
    $phpNamespace->add($classTypeInterface);

    // add namespace to php file
    $phpFile->addNamespace($phpNamespace);

    // print
    $content = $printer->printFile($phpFile);

    // store
    echo 'Writing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}