<?php

use Gzhegow\Support\Filter;


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
$namespace->addUse(\Gzhegow\Support\Filter::class, 'Filter');
$namespace->addUse(\Gzhegow\Support\Domain\Filter\InvokableInfoVal::class, 'InvokableInfoVal');
$namespace->addUse(\Gzhegow\Support\Exceptions\Logic\InvalidArgumentException::class, 'InvalidArgumentException');

// class
$moduleAssert = new \Nette\PhpGenerator\ClassType('GeneratedAssert');
$moduleAssert->setAbstract();

// add dependencies
$property = new \Nette\PhpGenerator\Property('filter');
$property->setComment(implode("\n", [
    '',
    '@var Filter',
    '',
]));
$moduleAssert->addMember($property);

// add constructor
$method = new \Nette\PhpGenerator\Method('__construct');
$method->setComment(implode("\n", [
    '',
    '@param Filter $filter',
    '',
]));
$method->setBody('$this->filter = $filter;');
$method->setPublic();
$method->addParameter('filter')->setType(Filter::class);
$moduleAssert->addMember($method);

// add methods
// call()
$method = new \Nette\PhpGenerator\Method('call');
$method->setPublic();
$method->addParameter('customFilter')->setType('string');
$method->addParameter('arguments');
$method->setVariadic();
$method->setComment(implode("\n", [
    '',
    '@param string $customFilter',
    '@param mixed ...$arguments',
    '',
    '@return null|mixed',
]));
$method->setBody(implode("\n", [
    'if (null === ( $filtered = $this->filter->call($customFilter, ...$arguments) )) {',
    '    throw $this->flushThrowable()',
    '        ?? new InvalidArgumentException($this->flushMessage(...$arguments)',
    '            ?? array_merge([ \'Invalid \' . $customFilter . \' passed: %s\' ], $arguments)',
    '        );',
    '}',
    '',
    'return $filtered;',
]));
$moduleAssert->addMember($method);

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

    $methodNameNew = 'assert' . ( $filterName = $generator->str_starts($methodName, 'filter') );

    $lines = explode("\n", $methodComment);
    foreach ( $lines as $i => $line ) {
        if (false !== mb_strpos($line, $separator = '@return')) {
            $parts = explode($separator, $line);

            $type = ltrim($parts[ 1 ]);

            $lines[ $i ] = implode($separator, [
                $parts[ 0 ],
                ' ' . ( $generator->str_starts($type, 'null|') ?? $type ),
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
    // $methodNew->setComment($methodComment);
    $methodNew->setComment($methodCommentNew);
    $methodNew->setReturnType($method->getReturnType());
    $methodNew->setBody(implode("\n", [
        sprintf('if (null === ( $filtered = $this->filter->' . $methodName . '(%s) )) {', $arguments),
        '    throw $this->flushThrowable()',
        '        ?? new InvalidArgumentException($this->flushMessage(...func_get_args())',
        '            ?? array_merge([ \'Invalid ' . $filterName . ' passed: %s\' ], func_get_args())',
        '        );',
        '}',
        '',
        'return $filtered;',
    ]));

    $moduleAssert->addMember($methodNew);
}

// add methods
// flushMessage()
$method = new \Nette\PhpGenerator\Method('flushMessage');
$method->setVariadic();
$method->setComment(implode("\n", [
    '@param mixed ...$arguments',
    '',
    '@return null|string|array',
]));
$method->addParameter('arguments');
$method->setAbstract();
$method->setPublic();
$moduleAssert->addMember($method);

// add to namespace
$namespace->add($moduleAssert);

// print
$content = $printer->printFile($phpFile);

// store
$filepath = __ROOT__ . '/src/Domain/Filter/Generated/GeneratedAssert.php';

echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);
