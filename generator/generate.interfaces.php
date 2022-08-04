<?php

require_once __DIR__ . '/generator.php';

require __DIR__ . '/generate.interfaces.clear.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator(
    $supportFactory->getLoader(),
    $supportFactory->getStr()
);


// list
$interfaces = [
    'IArr'      => [ \Gzhegow\Support\ZArr::class ],
    'IAssert'   => [ \Gzhegow\Support\ZAssert::class, \Gzhegow\Support\Generated\GeneratedAssert::class ],
    'ICalendar' => [ \Gzhegow\Support\ZCalendar::class ],
    'ICli'      => [ \Gzhegow\Support\ZCli::class ],
    'ICmp'      => [ \Gzhegow\Support\ZCmp::class ],
    'ICriteria' => [ \Gzhegow\Support\ZCriteria::class ],
    'ICurl'     => [ \Gzhegow\Support\ZCurl::class ],
    'IDebug'    => [ \Gzhegow\Support\ZDebug::class ],
    'IEnv'      => [ \Gzhegow\Support\ZEnv::class ],
    'IFilter'   => [ \Gzhegow\Support\ZFilter::class ],
    'IFormat'   => [ \Gzhegow\Support\ZFormat::class ],
    'IFs'       => [ \Gzhegow\Support\ZFs::class ],
    'ILoader'   => [ \Gzhegow\Support\ZLoader::class ],
    'IMath'     => [ \Gzhegow\Support\ZMath::class ],
    'INet'      => [ \Gzhegow\Support\ZNet::class ],
    'INum'      => [ \Gzhegow\Support\ZNum::class ],
    'IPath'     => [ \Gzhegow\Support\ZPath::class ],
    'IPhp'      => [ \Gzhegow\Support\ZPhp::class ],
    'IPreg'     => [ \Gzhegow\Support\ZPreg::class ],
    'IProf'     => [ \Gzhegow\Support\ZProf::class ],
    'IStr'      => [ \Gzhegow\Support\ZStr::class ],
    'IType'     => [ \Gzhegow\Support\ZType::class, \Gzhegow\Support\Generated\GeneratedType::class ],
    'IUri'      => [ \Gzhegow\Support\ZUri::class ],
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
        $moduleCopy = \Nette\PhpGenerator\ClassType::from($sourceClass);

        // @gzhegow > unable to override interface constant
        // foreach ( $moduleCopy->getConstants() as $constant ) {
        //     $moduleInterface->addMember($constant);
        // }

        foreach ( $moduleCopy->getMethods() as $method ) {
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

            $return = null
                ?? ( $methodReturnType === 'void' ? '' : null )
                ?? ( $methodReturnType === \Generator::class ? 'yield from ' : null )
                ?? 'return ';

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