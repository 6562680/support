<?php

require_once __DIR__ . '/generator.php';

$generator = new Gzhegow_Support_Generator();


// list
$facades = [
    'FArr'      => [ \Gzhegow\Support\IArr::class, \Gzhegow\Support\Arr::class ],
    'FAssert'   => [ \Gzhegow\Support\IAssert::class, \Gzhegow\Support\Assert::class, \Gzhegow\Support\Generated\GeneratedAssert::class ],
    'FCalendar' => [ \Gzhegow\Support\ICalendar::class, \Gzhegow\Support\Calendar::class ],
    'FCli'      => [ \Gzhegow\Support\ICli::class, \Gzhegow\Support\Cli::class ],
    'FCmp'      => [ \Gzhegow\Support\ICmp::class, \Gzhegow\Support\Cmp::class ],
    'FCriteria' => [ \Gzhegow\Support\ICriteria::class, \Gzhegow\Support\Criteria::class ],
    'FCurl'     => [ \Gzhegow\Support\ICurl::class, \Gzhegow\Support\Curl::class ],
    'FDebug'    => [ \Gzhegow\Support\IDebug::class, \Gzhegow\Support\Debug::class ],
    'FEnv'      => [ \Gzhegow\Support\IEnv::class, \Gzhegow\Support\Env::class ],
    'FFilter'   => [ \Gzhegow\Support\IFilter::class, \Gzhegow\Support\Filter::class ],
    'FFormat'   => [ \Gzhegow\Support\IFormat::class, \Gzhegow\Support\Format::class ],
    'FFs'       => [ \Gzhegow\Support\IFs::class, \Gzhegow\Support\Fs::class ],
    'FLoader'   => [ \Gzhegow\Support\ILoader::class, \Gzhegow\Support\Loader::class ],
    'FMath'     => [ \Gzhegow\Support\IMath::class, \Gzhegow\Support\Math::class ],
    'FNet'      => [ \Gzhegow\Support\INet::class, \Gzhegow\Support\Net::class ],
    'FNum'      => [ \Gzhegow\Support\INum::class, \Gzhegow\Support\Num::class ],
    'FPath'     => [ \Gzhegow\Support\IPath::class, \Gzhegow\Support\Path::class ],
    'FPhp'      => [ \Gzhegow\Support\IPhp::class, \Gzhegow\Support\Php::class ],
    'FPreg'     => [ \Gzhegow\Support\IPreg::class, \Gzhegow\Support\Preg::class ],
    'FProf'     => [ \Gzhegow\Support\IProf::class, \Gzhegow\Support\Prof::class ],
    'FStr'      => [ \Gzhegow\Support\IStr::class, \Gzhegow\Support\Str::class ],
    'FType'     => [ \Gzhegow\Support\IType::class, \Gzhegow\Support\Type::class, \Gzhegow\Support\Generated\GeneratedType::class ],
    'FUri'      => [ \Gzhegow\Support\IUri::class, \Gzhegow\Support\Uri::class ],
];

foreach ( $facades as $facade => $sourceClasses ) {
    // interface
    $interface = array_shift($sourceClasses);

    // original
    $originalClass = reset($sourceClasses);
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
        '@noinspection RedundantSuppression',
    ]));

    // namespace
    $phpFile->addNamespace(
        $namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Facades')
    );
    $namespace->addUse($interface);
    foreach ( $sourceClasses as $sourceClass ) {
        $namespace->addUse($sourceClass);

        foreach ( $generator->loaderClassUses($sourceClass) as $use ) {
            $namespace->addUse($use);
        }
    }

    // class
    $moduleFacade = new \Nette\PhpGenerator\ClassType($facade);

    // copy methods
    // copy methods
    foreach ( $sourceClasses as $sourceClass ) {
        $moduleCopy = \Nette\PhpGenerator\ClassType::from($sourceClass);

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

            $moduleFacade->addMember($methodNew);
        }
    }

    // add to namespace
    $namespace->add($moduleFacade);

    // print
    $content = $printer->printFile($phpFile);

    // store
    $filepath = __ROOT__ . '/src/Facades/' . $facade . '.php';

    echo 'Writing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}
