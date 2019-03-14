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

namespace Niko9911\JsonToEntity\Tests\Unit;

use Niko9911\JsonToEntity\Domain\Exception\MappingException;
use Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException;
use Niko9911\JsonToEntity\Tests\Stubs\Unit\BasicUnitTest\BasicUnitTestEntity as Entity;
use Niko9911\JsonToEntity\Tests\Stubs\Unit\BasicUnitTest\BasicUnitTestEntityBarMissing as EntityBarMissing;
use Niko9911\JsonToEntity\Tests\Stubs\Unit\BasicUnitTest\BasicUnitTestEntityNoGetters as EntityNoGet;
use Niko9911\JsonToEntity\Tests\UnitTestCase;

/**
 * Class BasicUnitTest.
 *
 * @internal
 */
final class BasicUnitTest extends UnitTestCase
{
    /** @var Entity */
    private $expectedEntity;

    /**
     * Will set expected results.
     */
    protected function setUp(): void
    {
        $this->expectedEntity = new Entity('Some_Bar', 10, ['a', 'b', 'c']);
        parent::setUp();
    }

    /**
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testSuccessFlow(): void
    {
        $this->assertEquals($this->expectedEntity, self::mapper()->map(self::getStubJson('success'), Entity::class));
    }

    /**
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testSuccessFlowHyphensFooDashBar(): void
    {
        $this->assertEquals($this->expectedEntity, self::mapper()->map(self::getStubJson('successHyphens'), Entity::class));
    }

    /**
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testFailureNoGetters(): void
    {
        $this->expectExceptionMessage('Property bar is not declared in Niko9911\JsonToEntity\Tests\Stubs\Unit\BasicUnitTest\BasicUnitTestEntityNoGetters. 
                NOTE: You need also getters for properties. This is intended behavior due Symfony PropertyInfo library.');
        $this->expectException(PropertyUndefinedException::class);
        self::mapper()->map(self::getStubJson('success'), EntityNoGet::class);
    }

    /**
     * @throws PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testFailureBarMissing(): void
    {
        $this->expectExceptionMessage('Property bar doesnt exist in Niko9911\JsonToEntity\Tests\Stubs\Unit\BasicUnitTest\BasicUnitTestEntityBarMissing.');
        $this->expectException(PropertyUndefinedException::class);
        self::mapper()->map(self::getStubJson('success'), EntityBarMissing::class);
    }

    /**
     * @throws PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testFailureBarMissingNoException(): void
    {
        $this->assertEquals(
            new EntityBarMissing(10, ['a', 'b', 'c']),
            self::mapper(false, true)
                ->map(self::getStubJson('success'), EntityBarMissing::class)
        );
    }

    /**
     * @throws PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testFailureReflectionInvalidClass(): void
    {
        $this->expectException(MappingException::class);
        $this->expectExceptionMessage('Class Niko9911\JsonToEntity\Tests\Unit\InvalidStubsClassTest does not exist');
        self::mapper()->map(self::getStubJson('success'), InvalidStubsClassTest::class);
    }
}
