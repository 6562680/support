<?php

require_once __DIR__ . '/generator.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator();


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
    $phpNamespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support');

    // class
    $classTypeInterface = new \Nette\PhpGenerator\ClassType($interface);
    $classTypeInterface->setInterface();

    // copy uses
    foreach ( $sourceClasses as $sourceClass ) {
        $phpNamespace->addUse($sourceClass);

        foreach ( $generator->getLoader()->getUseStatements($sourceClass) as $use ) {
            $phpNamespace->addUse($use);
        }
    }

    // copy methods
    foreach ( $sourceClasses as $sourceClass ) {
        $classTypeSource = \Nette\PhpGenerator\ClassType::from($sourceClass, false, false);

        // @gzhegow > causes unable to override interface constant
        // foreach ( $moduleCopy->getConstants() as $constant ) {
        //     $moduleInterface->addMember($constant);
        // }

        foreach ( $classTypeSource->getMethods() as $method ) {
            if (! $method->isPublic()) {
                continue;
            }

            if ($method->isStatic()) {
                continue;
            }

            $methodName = $method->getName();
            if (null !== $generator->getStr()->starts($methodName, '__')) {
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

            $methodNew = new \Nette\PhpGenerator\Method($methodName);
            $methodNew->setReturnNullable($method->isReturnNullable());
            $methodNew->setReturnReference($method->getReturnReference());
            $methodNew->setVariadic($method->isVariadic());
            $methodNew->setParameters($methodParameters);
            $methodNew->setReturnType($methodReturnType);
            $methodNew->setPublic();
            $methodNew->setComment($methodCommentNew);

            $classTypeInterface->addMember($methodNew);
        }
    }

    // add to interface to namespace
    $phpNamespace->add($classTypeInterface);

    // add namespace to php file
    $phpFile->addNamespace($phpNamespace);

    // print
    $content = $printer->printFile($phpFile);

    // store
    echo 'Writing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}