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

namespace Niko9911\JsonToEntity\Domain;

/**
 * Class EntityBuilder.
 *
 * @internal
 */
class EntityBuilder
{
    /** @var \ReflectionClass */
    protected $class;

    /** @var \ReflectionClass */
    protected $reflection;

    /**
     * EntityBuilder constructor.
     *
     * @param string $class
     *
     * @throws \ReflectionException
     */
    public function __construct(string $class)
    {
        /* @noinspection PhpUnhandledExceptionInspection */
        $this->class = (new \ReflectionClass($class))->newInstanceWithoutConstructor();
        $this->reflection = new \ReflectionClass($this->class);
    }

    /**
     * @param string $propertyName
     * @param        $value
     *
     * @return EntityBuilder
     *
     * @throws \ReflectionException
     */
    public function addProperty(string $propertyName, $value): self
    {
        $prop = $this->reflection->getProperty($propertyName);
        $prop->setAccessible(true);
        $prop->setValue($this->class, $value);

        return $this;
    }

    /**
     * @return object
     */
    public function getEntity(): object
    {
        return $this->class;
    }
}
