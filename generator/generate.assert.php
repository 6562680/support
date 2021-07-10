<?php


require_once __DIR__ . '/generator.php';

$generator = new Gzhegow_Support_Generator();


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
$namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Generated');
$phpFile->addNamespace($namespace);
$namespace->addUse(\Gzhegow\Support\IFilter::class);
$namespace->addUse(\Gzhegow\Support\Domain\Filter\ValueObject\InvokableInfo::class);
$namespace->addUse(\Gzhegow\Support\Exceptions\Logic\InvalidArgumentException::class);

// class
$moduleAssert = \Nette\PhpGenerator\ClassType::withBodiesFrom(Gzhegow_Support_Generator_AssertBlueprint::class);
$moduleAssert->setName('GeneratedAssert');
$moduleAssert->setAbstract();
$moduleAssert->setImplements([ \Gzhegow\Support\IAssert::class ]);

// copy methods
$moduleCopy = \Nette\PhpGenerator\ClassType::from(\Gzhegow\Support\Filter::class);
$moduleCopy->removeMethod('assert');
$moduleCopy->removeMethod('php');
$moduleCopy->removeMethod('type');
//
$moduleCopy->removeMethod('bind');
$moduleCopy->removeMethod('call');
//
$moduleCopy->removeMethod('filter');
$moduleCopy->removeMethod('addCustomFilter');
$moduleCopy->removeMethod('findCustomFilter');
$moduleCopy->removeMethod('getCustomFilters');
$moduleCopy->removeMethod('replaceCustomFilter');
//
$moduleCopy->removeMethod('me');
foreach ( $moduleCopy->getMethods() as $method ) {
    if ('__construct' === ( $methodName = $method->getName() )) {
        continue;
    }

    if (null === ( $filterName = $generator->strStarts($methodName, 'filter') )) {
        continue;
    }

    $methodParameters = $method->getParameters();
    $methodComment = $method->getComment();

    $methodNameNew = 'assert' . $filterName;

    $lines = explode("\n", $methodComment);
    foreach ( $lines as $i => $line ) {
        if (false !== mb_strpos($line, $separator = '@return')) {
            $parts = explode($separator, $line);

            $type = ltrim($parts[ 1 ]);

            $lines[ $i ] = implode($separator, [
                $parts[ 0 ],
                ' ' . ( $generator->strStarts($type, 'null|') ?? $type ),
            ]);
        }
    }
    $methodCommentNew = implode("\n", $lines);

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

    $arguments = implode(',', $arguments);

    $methodNew = new \Nette\PhpGenerator\Method($methodNameNew);
    $methodNew->setVariadic($method->isVariadic());
    $methodNew->setReturnNullable($method->isReturnNullable());
    $methodNew->setParameters($methodParameters);
    $methodNew->setPublic();
    $methodNew->setComment($methodCommentNew);
    $methodNew->setReturnType($method->getReturnType());
    $methodNew->setBody(
        implode("\n", [
            '' . sprintf('if (null === ( $filtered = $this->filter->%s(%s) )) {', $methodName, $arguments),
            '    throw $this->getThrowableOr(',
            '        new InvalidArgumentException($this->getErrorOr(',
            '            \'Invalid ' . $filterName . ' passed: %s\', ...func_get_args()',
            '        ))',
            '    );',
            '}',
            '',
            'return $filtered;',
        ])
    );

    $moduleAssert->addMember($methodNew);
}

// add methods
// flushMessage()
// $method = new \Nette\PhpGenerator\Method('flushMessage');
// $method->setVariadic();
// $method->setComment(implode("\n", [
//     '@param mixed ...$arguments',
//     '',
//     '@return null|string|array',
// ]));
// $method->addParameter('arguments');
// $method->setAbstract();
// $method->setPublic();
// $moduleAssert->addMember($method);

// add to namespace
$namespace->add($moduleAssert);

// print
$content = $printer->printFile($phpFile);

// store
$filepath = __ROOT__ . '/src/Generated/GeneratedAssert.php';

echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);
