<?php

declare(strict_types=1);

/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is released under MIT license by Niko Granö.
 *
 * @copyright Niko Granö <niko9911@ironlions.fi> (https://granö.fi)
 *
 */

namespace Niko9911\JsonToEntity\Tests;

\defined('DS') ?: \define('DS', \DIRECTORY_SEPARATOR);
\defined('STUBS') ?: \define('STUBS', __DIR__.DS.'Stubs'.DS);
\defined('STUBS_UNIT') ?: \define('STUBS_UNIT', STUBS.'Unit'.DS);

use Niko9911\JsonToEntity\Mapper;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    /**
     * Returns path to stubs directory.
     *
     * @param string $file
     *
     * @return string
     */
    protected static function getStubs(string $file = ''): string
    {
        $namespace = \explode('\\', static::class);
        unset($namespace[0],$namespace[1],$namespace[2],$namespace[3]);
        $dir = STUBS_UNIT.\implode(DS, $namespace).DS.$file;

        if (!\file_exists($dir)) {
            throw new \LogicException("Requested resource is missing. Please create $dir.");
        }

        return $dir;
    }

    /**
     * @param string $filename
     *
     * @return \stdClass
     */
    protected static function getStubJson(string $filename): \stdClass
    {
        return \json_decode(\file_get_contents(self::getStubs("$filename.json")));
    }

    protected static function mapper(
        bool $noExceptionOnNonNullable = false,
        bool $noExceptionOnUndefinedProperty = false
    ): Mapper {
        return new Mapper($noExceptionOnNonNullable, $noExceptionOnUndefinedProperty);
    }
}
