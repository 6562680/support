<?php

use Gzhegow\Support\Filter;
use Gzhegow\Support\Domain\Filter\ValueObjects\InvokableInfo;


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
$namespace = new \Nette\PhpGenerator\PhpNamespace('Gzhegow\\Support\\Domain\\Filter\\Generated');
$phpFile->addNamespace($namespace);
$namespace->addUse(Filter::class, 'Filter');
$namespace->addUse(InvokableInfo::class, 'InvokableInfo');
$namespace->addUse(\Gzhegow\Support\Exceptions\Logic\InvalidArgumentException::class, 'InvalidArgumentException');

// class
$moduleAssert = \Nette\PhpGenerator\ClassType::withBodiesFrom(Gzhegow_Support_Generator_AssertBlueprint::class);
$moduleAssert->setName('GeneratedAssert');
$moduleAssert->setAbstract();

// copy methods
$moduleCopy = \Nette\PhpGenerator\ClassType::from(Filter::class);
$moduleCopy->removeMethod('getCustomFilters');
$moduleCopy->removeMethod('addCustomFilter');
$moduleCopy->removeMethod('assert');
$moduleCopy->removeMethod('filter');
$moduleCopy->removeMethod('php');
$moduleCopy->removeMethod('type');
$moduleCopy->removeMethod('call');
$moduleCopy->removeMethod('bind');
$moduleCopy->removeMethod('replaceCustomFilter');
$moduleCopy->removeMethod('findCustomFilter');
foreach ( $moduleCopy->getMethods() as $method ) {
    $methodName = $method->getName();

    if ('__construct' === $methodName) {
        continue;
    }

    $methodParameters = $method->getParameters();
    $methodComment = $method->getComment();

    $methodNameNew = 'assert' . ( $filterName = $generator->strStarts($methodName, 'filter') );

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
            '    throw $this->throwableOr(',
            '        new InvalidArgumentException($this->messageOr(',
            '            [ \'Invalid ' . $filterName . ' passed: %s\', func_get_args() ]',
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
$filepath = __ROOT__ . '/src/Domain/Filter/Generated/GeneratedAssert.php';

echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);
