<?php

require_once __DIR__ . '/generator.php';

require __DIR__ . '/generate.facades.clear.php';


$supportFactory = \Gzhegow\Support\SupportFactory::getInstance();

$generator = new Gzhegow_Support_Generator(
    $supportFactory->getLoader(),
    $supportFactory->getStr()
);


// list
$facades = [
    'Arr'      => [ \Gzhegow\Support\IArr::class, \Gzhegow\Support\ZArr::class ],
    'Assert'   => [ \Gzhegow\Support\IAssert::class, \Gzhegow\Support\ZAssert::class, \Gzhegow\Support\Generated\GeneratedAssert::class ],
    'Calendar' => [ \Gzhegow\Support\ICalendar::class, \Gzhegow\Support\ZCalendar::class ],
    'Cli'      => [ \Gzhegow\Support\ICli::class, \Gzhegow\Support\ZCli::class ],
    'Cmp'      => [ \Gzhegow\Support\ICmp::class, \Gzhegow\Support\ZCmp::class ],
    'Criteria' => [ \Gzhegow\Support\ICriteria::class, \Gzhegow\Support\ZCriteria::class ],
    'Curl'     => [ \Gzhegow\Support\ICurl::class, \Gzhegow\Support\ZCurl::class ],
    'Debug'    => [ \Gzhegow\Support\IDebug::class, \Gzhegow\Support\ZDebug::class ],
    'Env'      => [ \Gzhegow\Support\IEnv::class, \Gzhegow\Support\ZEnv::class ],
    'Filter'   => [ \Gzhegow\Support\IFilter::class, \Gzhegow\Support\ZFilter::class ],
    'Format'   => [ \Gzhegow\Support\IFormat::class, \Gzhegow\Support\ZFormat::class ],
    'Fs'       => [ \Gzhegow\Support\IFs::class, \Gzhegow\Support\ZFs::class ],
    'Loader'   => [ \Gzhegow\Support\ILoader::class, \Gzhegow\Support\ZLoader::class ],
    'Math'     => [ \Gzhegow\Support\IMath::class, \Gzhegow\Support\ZMath::class ],
    'Net'      => [ \Gzhegow\Support\INet::class, \Gzhegow\Support\ZNet::class ],
    'Num'      => [ \Gzhegow\Support\INum::class, \Gzhegow\Support\ZNum::class ],
    'Path'     => [ \Gzhegow\Support\IPath::class, \Gzhegow\Support\ZPath::class ],
    'Php'      => [ \Gzhegow\Support\IPhp::class, \Gzhegow\Support\ZPhp::class ],
    'Preg'     => [ \Gzhegow\Support\IPreg::class, \Gzhegow\Support\ZPreg::class ],
    'Prof'     => [ \Gzhegow\Support\IProf::class, \Gzhegow\Support\ZProf::class ],
    'Str'      => [ \Gzhegow\Support\IStr::class, \Gzhegow\Support\ZStr::class ],
    'Type'     => [ \Gzhegow\Support\IType::class, \Gzhegow\Support\ZType::class, \Gzhegow\Support\Generated\GeneratedType::class ],
    'Uri'      => [ \Gzhegow\Support\IUri::class, \Gzhegow\Support\ZUri::class ],
];

// deps
$printer = new \Nette\PhpGenerator\PsrPrinter();

foreach ( $facades as $facade => $sourceClasses ) {
    // vars
    $filepath = __ROOT__ . '/src/Facades/' . $facade . '.php';

    // interface
    $interface = array_shift($sourceClasses);

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
    $phpNamespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Facades');

    // class
    $classTypeFacade = new \Nette\PhpGenerator\ClassType($facade);

    // copy uses
    $phpNamespace->addUse(\Gzhegow\Support\SupportFactory::class);
    $phpNamespace->addUse($interface);
    foreach ( $sourceClasses as $sourceClass ) {
        $phpNamespace->addUse($sourceClass);

        foreach ( $generator->getLoader()->getUseStatements($sourceClass) as $use ) {
            $phpNamespace->addUse($use);
        }
    }

    // copy methods
    foreach ( $sourceClasses as $sourceClass ) {
        $moduleCopy = \Nette\PhpGenerator\ClassType::from($sourceClass);

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
            $methodNew->setStatic();
            $methodNew->setComment($methodCommentNew);
            $methodNew->setBody(implode("\n", [
                sprintf(
                    $return . 'static::getInstance()->' . $methodName . '(%s);',
                    implode(', ', $arguments),
                ),
            ]));

            $classTypeFacade->addMember($methodNew);
        }
    }

    // add methods
    $method = new \Nette\PhpGenerator\Method('getInstance');
    $method->setPublic();
    $method->setStatic();
    $method->setReturnType($interface);
    $method->setComment(implode("\n", [
        '@return ' . substr($interface, strrpos($interface, '\\') + 1),
    ]));
    $method->setBody(implode("\n", [
        sprintf('return SupportFactory::getInstance()->get%s();', $facade),
    ]));
    $classTypeFacade->addMember($method);

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