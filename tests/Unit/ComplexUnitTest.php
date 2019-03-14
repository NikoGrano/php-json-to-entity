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

use Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException;
use Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException;
use Niko9911\JsonToEntity\Tests\Stubs\Unit\ComplexUnitTest\ComplexMainEntity as Entity;
use Niko9911\JsonToEntity\Tests\Stubs\Unit\ComplexUnitTest\ComplexSubEntity;
use Niko9911\JsonToEntity\Tests\Stubs\Unit\ComplexUnitTest\ComplexSubSubEntity;
use Niko9911\JsonToEntity\Tests\UnitTestCase;

/**
 * Class ComplexUnitTest.
 *
 * @internal
 */
final class ComplexUnitTest extends UnitTestCase
{
    /** @var Entity */
    private $expectedEntity;

    /**
     * Will set expected results.
     */
    protected function setUp(): void
    {
        $this->expectedEntity = new Entity(
            new ComplexSubEntity(
                new ComplexSubSubEntity(
                    10,
                    'Chuck Norris'
                ),
                20.50,
                false
            ),
            ['a', 10, true, 1.2],
            [
                'string' => 'b',
                'int'    => 15,
                'bool'   => false,
                'float'  => 1.5,
            ]
        );
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
    public function testFailureSubSubNotNullable(): void
    {
        $this->expectException(PropertyNotNullableException::class);
        $this->expectExceptionMessage('Property id is not nullable!');
        self::mapper()->map(self::getStubJson('failureSubSubNotNullable'), Entity::class);
    }

    /**
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testFailurePropertyNotNullable(): void
    {
        $this->expectException(PropertyNotNullableException::class);
        $this->expectExceptionMessage('Property simple is not nullable!');
        self::mapper()->map(self::getStubJson('failurePropertyNotNullable'), Entity::class);
    }

    /**
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testFailedValueCannotBeCastedStringToInt(): void
    {
        $this->expectException(ValueCannotBeCastedToRequestedTypeException::class);
        $this->expectExceptionMessage('Cannot cast id to int. ');
        self::mapper()->map(self::getStubJson('failureCastStringToInt'), Entity::class);
    }

    /**
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testFailedValueCannotBeCastedTooBigInt(): void
    {
        $this->expectException(ValueCannotBeCastedToRequestedTypeException::class);
        $this->expectExceptionMessage('Cannot cast id to int. Too big value. See PHP_INT_MAX or mark property as double.');
        self::mapper()->map(self::getStubJson('failureCastTooBigInt'), Entity::class);
    }

    /**
     * @throws \Niko9911\JsonToEntity\Domain\Exception\MappingException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException
     * @throws \Niko9911\JsonToEntity\Domain\Exception\ValueCannotBeCastedToRequestedTypeException
     */
    public function testFailedPropertyCannotBeNull(): void
    {
        $this->expectException(PropertyNotNullableException::class);
        //$this->expectExceptionMessage('Cannot cast id to int. Too big value. See PHP_INT_MAX or mark property as double.');
        self::mapper()->map(self::getStubJson('failurePropertyCannotBeNull'), Entity::class);
    }
}
