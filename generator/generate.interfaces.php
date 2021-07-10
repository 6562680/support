<?php

require_once __DIR__ . '/generator.php';

$generator = new Gzhegow_Support_Generator();


// list
$interfaces = [
    'IArr'      => [ \Gzhegow\Support\Arr::class ],
    'IAssert'   => [ \Gzhegow\Support\Assert::class, \Gzhegow\Support\Generated\GeneratedAssert::class ],
    'ICalendar' => [ \Gzhegow\Support\Calendar::class ],
    'ICli'      => [ \Gzhegow\Support\Cli::class ],
    'ICmp'      => [ \Gzhegow\Support\Cmp::class ],
    'ICriteria' => [ \Gzhegow\Support\Criteria::class ],
    'ICurl'     => [ \Gzhegow\Support\Curl::class ],
    'IDebug'    => [ \Gzhegow\Support\Debug::class ],
    'IEnv'      => [ \Gzhegow\Support\Env::class ],
    'IFilter'   => [ \Gzhegow\Support\Filter::class ],
    'IFormat'   => [ \Gzhegow\Support\Format::class ],
    'IFs'       => [ \Gzhegow\Support\Fs::class ],
    'ILoader'   => [ \Gzhegow\Support\Loader::class ],
    'IMath'     => [ \Gzhegow\Support\Math::class ],
    'INet'      => [ \Gzhegow\Support\Net::class ],
    'INum'      => [ \Gzhegow\Support\Num::class ],
    'IPath'     => [ \Gzhegow\Support\Path::class ],
    'IPhp'      => [ \Gzhegow\Support\Php::class ],
    'IPreg'     => [ \Gzhegow\Support\Preg::class ],
    'IProf'     => [ \Gzhegow\Support\Prof::class ],
    'IStr'      => [ \Gzhegow\Support\Str::class ],
    'IType'     => [ \Gzhegow\Support\Type::class, \Gzhegow\Support\Generated\GeneratedType::class ],
    'IUri'      => [ \Gzhegow\Support\Uri::class ],
];

foreach ( $interfaces as $interface => $sourceClasses ) {
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
    ]));

    // namespace
    $namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support');
    $phpFile->addNamespace($namespace);

    foreach ( $sourceClasses as $sourceClass ) {
        $namespace->addUse($sourceClass);

        foreach ( $generator->loaderClassUses($sourceClass) as $use ) {
            $namespace->addUse($use);
        }
    }

    // class
    $moduleInterface = new \Nette\PhpGenerator\ClassType($interface);
    $moduleInterface->setInterface();

    // copy methods
    foreach ( $sourceClasses as $sourceClass ) {
        $moduleCopy = \Nette\PhpGenerator\ClassType::from($sourceClass);

        // @gzhegow, unable to override interface constant
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
            $methodNew->setComment($methodCommentNew);

            $moduleInterface->addMember($methodNew);
        }
    }

    // add to namespace
    $namespace->add($moduleInterface);

    // print
    $content = $printer->printFile($phpFile);

    // store
    $filepath = __ROOT__ . '/src/' . $interface . '.php';

    echo 'Writing file: ' . $filepath . PHP_EOL;
    file_put_contents($filepath, $content);
}
