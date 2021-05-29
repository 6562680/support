<?php

use Gzhegow\Support\Filter;


require_once __DIR__ . '/vendor/autoload.php';


$fnStarts = function (string $str, string $needle = null, bool $ignoreCase = true) : ?string {
    $needle = $needle ?? '';

    if ('' === $str) return null;
    if ('' === $needle) return $str;

    $pos = $ignoreCase
        ? mb_stripos($str, $needle)
        : mb_strpos($str, $needle);

    $result = 0 === $pos
        ? mb_substr($str, mb_strlen($needle))
        : null;

    return $result;
};

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
$namespace->addUse(\Gzhegow\Support\Domain\Filter\CallableInfoVO::class, 'CallableInfoVO');

// class
$moduleType = new \Nette\PhpGenerator\ClassType('GeneratedType');
$moduleType->setAbstract();

// add dependencies
$property = new \Nette\PhpGenerator\Property('filter');
$property->setComment(implode("\n", [
    '',
    '@var Filter',
    '',
]));
$moduleType->addMember($property);

$method = new \Nette\PhpGenerator\Method('__construct');
$method->setComment(implode("\n", [
    '',
    '@param Filter $filter',
    '',
]));
$method->setBody('$this->filter = $filter;');
$method->setPublic();
$method->addParameter('filter')->setType(Filter::class);
$moduleType->addMember($method);

// add methods
$method = new \Nette\PhpGenerator\Method('call');
$method->setPublic();
$method->addParameter('customFilter')->setType('string');
$method->addParameter('arguments');
$method->setVariadic();
$method->setReturnType('bool');
$method->setComment(implode("\n", [
    '',
    '@param string $customFilter',
    '@param mixed ...$arguments',
    '',
    '@return bool',
]));
$method->setBody(implode("\n", [
    'return null !== $this->filter->call($customFilter, ...$arguments);',
]));
$moduleType->addMember($method);

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

    $methodNameNew = 'is' . ( $filterName = $fnStarts($methodName, 'filter') );

    $lines = explode("\n", $methodComment);
    foreach ( $lines as $i => $line ) {
        if (false !== mb_strpos($line, $separator = '@return')) {
            $parts = explode($separator, $line);

            $lines[ $i ] = implode($separator, [ $parts[ 0 ], ' bool' ]);
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

    $methodNew = new \Nette\PhpGenerator\Method($methodNameNew);
    $methodNew->setVariadic($method->isVariadic());
    $methodNew->setReturnNullable($method->isReturnNullable());
    $methodNew->setParameters($methodParameters);
    $methodNew->setPublic();
    // $methodNew->setComment($methodComment);
    $methodNew->setComment($methodCommentNew);
    $methodNew->setReturnType('bool');
    $methodNew->setBody(implode("\n", [
        sprintf(
            'return null !== $this->filter->' . $methodName . '(%s);',
            implode(', ', $arguments),
        ),
    ]));

    $moduleType->addMember($methodNew);
}

// add to namespace
$namespace->add($moduleType);

// print
$content = $printer->printFile($phpFile);

// store
$filepath = __DIR__ . '/src/Domain/Filter/Generated/GeneratedType.php';

echo 'Writing file: ' . $filepath . PHP_EOL;
file_put_contents($filepath, $content);
