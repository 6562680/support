<?php

use Nette\PhpGenerator\Method;
use Gzhegow\Support\Traits\Load\StrLoadTrait;
use Gzhegow\Support\Traits\Load\LoaderLoadTrait;


defined('__ROOT__') or define('__ROOT__', __DIR__ . '/..');

require_once __DIR__ . '/../vendor/autoload.php';


/**
 * Class
 */
class Gzhegow_Support_Generator
{
    use LoaderLoadTrait;
    use StrLoadTrait;
}

/**
 * Class
 */
class Gzhegow_Support_Generator_FacadeGenerator extends Gzhegow_Support_Generator
{
    /**
     * @param string $methodName
     * @param array  $arguments
     *
     * @return string
     */
    public function generateMethodBodyDefault(
        string $methodName, array $arguments
    ) : string
    {
        return sprintf(
            "return static::getInstance()->${methodName}(%s);",
            implode(', ', $arguments),
        );
    }

    /**
     * @param string $methodName
     * @param array  $arguments
     *
     * @return string
     */
    public function generateMethodBodyReturnTypeVoid(
        string $methodName, array $arguments
    ) : string
    {
        return sprintf(
            "static::getInstance()->${methodName}(%s);",
            implode(', ', $arguments),
        );
    }


    /**
     * @param string $methodName
     * @param array  $arguments
     *
     * @return string
     */
    public function generateMethodBodyReturnTypeGenerator(
        string $methodName, array $arguments
    ) : string
    {
        return sprintf(
            "yield from static::getInstance()->${methodName}(%s);",
            implode(', ', $arguments),
        );
    }

    /**
     * @param string $methodName
     * @param array  $arguments
     *
     * @return string
     */
    public function generateMethodBodyReturnTypeGeneratorByReference(
        string $methodName, array $arguments
    ) : string
    {
        return implode("\n", [
            sprintf(
                "foreach (static::getInstance()->${methodName}(%s) as \$ref) {",
                implode(', ', $arguments),
            ),
            '    yield $ref;',
            '}',
        ]);
    }


    /**
     * @param Method $sourceMethod
     * @param string $methodName
     * @param array  $arguments
     *
     * @return string
     */
    public function generateMethodBody(
        Method $sourceMethod,
        string $methodName, array $arguments
    ) : string
    {
        if ($sourceMethod->getReturnType() === 'void') {
            $result = $this->generateMethodBodyReturnTypeVoid($methodName, $arguments);

        } elseif ($sourceMethod->getReturnType() === \Generator::class) {
            $result = ( $sourceMethod->getReturnReference() )
                ? $this->generateMethodBodyReturnTypeGeneratorByReference($methodName, $arguments)
                : $this->generateMethodBodyReturnTypeGenerator($methodName, $arguments);

        } else {
            $result = $this->generateMethodBodyDefault($methodName, $arguments);
        }

        return $result;
    }
}


/**
 * Class
 */
class Gzhegow_Support_Generator_FilterGenerator extends Gzhegow_Support_Generator
{
    const GENERATE_ASSERT = 'assert';
    const GENERATE_FILTER = 'filter';
    const GENERATE_TYPE   = 'type';

    const THE_GENERATE_LIST = [
        self::GENERATE_ASSERT => true,
        self::GENERATE_FILTER => true,
        self::GENERATE_TYPE   => true,
    ];


    /**
     * @param string $sourceName
     * @param Method $sourceMethod
     * @param string $filterName
     * @param array  $arguments
     *
     * @return Method
     */
    public function generateMethodAssert(
        string $sourceName, Method $sourceMethod,
        string $filterName, array $arguments
    ) : Method
    {
        $methodComment = explode("\n", $sourceMethod->getComment());
        foreach ( $methodComment as $i => $line ) {
            if (false !== mb_strpos($line, $separator = '@return')) {
                $parts = explode($separator, $line);

                $type = ltrim($parts[ 1 ]);

                $methodComment[ $i ] = implode($separator, [
                    $parts[ 0 ],
                    ' ' . ( $this->getStr()->starts($type, 'null|') ?? $type ),
                ]);
            }
        }
        $methodComment = implode("\n", $methodComment);

        $methodNew = new Method('assert' . $filterName);
        $methodNew->setPublic();
        $methodNew->setParameters($sourceMethod->getParameters());
        $methodNew->setVariadic($sourceMethod->isVariadic());
        $methodNew->setReturnType($sourceMethod->getReturnType());
        $methodNew->setReturnNullable($sourceMethod->isReturnNullable());
        $methodNew->setComment($methodComment);
        $methodNew->setBody(
            implode("\n", [
                sprintf('if (null === ( $var = $this->get%s()->%s(%s) )) {',
                    $sourceName,
                    $sourceMethod->getName(),
                    implode(', ', $arguments)
                ),
                '    throw $this->getThrowableOr(',
                '        new InvalidArgumentException($this->getMessageOr(',
                '            \'Invalid `' . $filterName . '` passed: %s\', ...func_get_args()',
                '        ))',
                '    );',
                '}',
                '',
                'return $var;',
            ])
        );

        return $methodNew;
    }

    /**
     * @param string $sourceName
     * @param Method $sourceMethod
     * @param string $filterName
     * @param array  $arguments
     *
     * @return Method
     */
    public function generateMethodFilter(
        string $sourceName, Method $sourceMethod,
        string $filterName, array $arguments
    ) : Method
    {
        $methodNew = new Method('filter' . $filterName);
        $methodNew->setPublic();
        $methodNew->setParameters($sourceMethod->getParameters());
        $methodNew->setVariadic($sourceMethod->isVariadic());
        $methodNew->setReturnType($sourceMethod->getReturnType());
        $methodNew->setReturnNullable($sourceMethod->isReturnNullable());
        $methodNew->setComment($sourceMethod->getComment());
        $methodNew->setBody(
            implode("\n", [
                sprintf('return $this->get%s()->%s(%s);',
                    $sourceName,
                    $sourceMethod->getName(),
                    implode(', ', $arguments)
                ),
            ])
        );

        return $methodNew;
    }

    /**
     * @param string $sourceName
     * @param Method $sourceMethod
     * @param string $filterName
     * @param array  $arguments
     *
     * @return Method
     */
    public function generateMethodType(
        string $sourceName, Method $sourceMethod,
        string $filterName, array $arguments
    ) : Method
    {
        $methodComment = explode("\n", $sourceMethod->getComment());
        foreach ( $methodComment as $i => $line ) {
            if (false !== mb_strpos($line, $separator = '@return')) {
                $parts = explode($separator, $line);

                $methodComment[ $i ] = implode($separator, [ $parts[ 0 ], ' bool' ]);
            }
        }
        $methodComment = implode("\n", $methodComment);

        $methodNew = new Method('is' . $filterName);
        $methodNew->setPublic();
        $methodNew->setParameters($sourceMethod->getParameters());
        $methodNew->setVariadic($sourceMethod->isVariadic());
        $methodNew->setReturnType('bool');
        $methodNew->setReturnNullable(false);
        $methodNew->setComment($methodComment);
        $methodNew->setBody(
            implode("\n", [
                sprintf(
                    'return null !== $this->get%s()->%s(%s);',
                    $sourceName,
                    $sourceMethod->getName(),
                    implode(', ', $arguments),
                ),
            ])
        );

        return $methodNew;
    }


    /**
     * @return callable[]
     */
    public function mapGenerate() : array
    {
        return [
            self::GENERATE_TYPE   => [ $this, 'generateMethodType' ], // 1
            self::GENERATE_FILTER => [ $this, 'generateMethodFilter' ], // 2
            self::GENERATE_ASSERT => [ $this, 'generateMethodAssert' ], // 3
        ];
    }
}