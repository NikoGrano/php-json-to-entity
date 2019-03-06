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

namespace Niko9911\JsonToEntity;

include_once __DIR__.'/../vendor/autoload.php';

use Niko9911\JsonToEntity\Domain\EntityBuilder;
use Niko9911\JsonToEntity\Domain\Exception\MappingException;
use Niko9911\JsonToEntity\Domain\Exception\PropertyNotNullableException;
use Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException;
use Niko9911\JsonToEntity\Domain\Property\Inspector;
use Niko9911\JsonToEntity\Domain\Strings;
use Symfony\Component\PropertyInfo\Type;

class Mapper
{
    protected const COMPLEX_TYPES = ['resource', 'callable', 'iterable'];

    /**
     * @var bool
     */
    private $noExceptionOnNonNullable;
    /**
     * @var bool
     */
    private $noExceptionOnUndefinedProperty;

    /**
     * Mapper constructor.
     *
     * @param bool $noExceptionOnNonNullable
     * @param bool $noExceptionOnUndefinedProperty
     */
    public function __construct(
        bool $noExceptionOnNonNullable = false,
        bool $noExceptionOnUndefinedProperty = false
    ) {
        $this->noExceptionOnNonNullable = $noExceptionOnNonNullable;
        $this->noExceptionOnUndefinedProperty = $noExceptionOnUndefinedProperty;
    }

    /**
     * Map data all data in $json into the given $object class.
     *
     * @param object $json   JSON object structure from json_decode()
     * @param string $object entity to map $json data into
     *
     * @return object mapped object is returned
     *
     * @throws PropertyUndefinedException   Will be thrown if the given json value does not exist
     *                                      on the target entity. Can be override with the constructor
     *                                      parameter `noExceptionOnUndefinedProperty`
     * @throws PropertyNotNullableException Will be thrown in case of entity property
     *                                      does not accept null values. Can be override
     *                                      with the constructor parameter `noExceptionOnNonNullable`
     * @throws MappingException             Will be throw in case of something is wrong in the code.
     *                                      For example, the given entity class doesnt exist.
     */
    public function map(object $json, string $object): object
    {
        try {
            $reflection = new \ReflectionClass($object);
        } catch (\ReflectionException $e) {
            throw new MappingException($e->getMessage());
        }

        $providedProperties = [];
        foreach ($json as $key => $jsonValue) {
            $key = Strings::getSafeName($key);

            try {
                $reflectedProperty = Inspector::getReflectedProperty($reflection, $key);
            } catch (PropertyUndefinedException $e) {
                if ($this->noExceptionOnUndefinedProperty) {
                    continue;
                }

                throw $e;
            }

            $providedProperties[$key] = $this->getValueAsTypeParsed(
                $jsonValue,
                $reflectedProperty,
                $key
            );
        }

        if (!$this->noExceptionOnNonNullable) {
            foreach (Inspector::getAllMethodsWithTypes($object) as $item => $counterValues) {
                if (!isset($providedProperties[$item]) && !$counterValues->isNullable()) {
                    throw new PropertyNotNullableException($item);
                }
            }
        }

        try {
            $entityBuilder = new EntityBuilder($object);

            foreach ($providedProperties as $propertyName => $value) {
                $entityBuilder->addProperty($propertyName, $value);
            }
        } catch (\ReflectionException $e) {
            throw new MappingException($e->getMessage());
        }

        return $entityBuilder->getEntity();
    }

    /**
     * @param        $value
     * @param Type   $type
     * @param string $propertyName
     *
     * @return mixed
     *
     * @throws PropertyNotNullableException
     */
    protected function getValueAsTypeParsed($value, Type $type, string $propertyName)
    {
        if (null === $type->getClassName() && !\in_array($type->getBuiltinType(), static::COMPLEX_TYPES, false)) {
            \settype($value, $type->getBuiltinType());

            return $value;
        }

        if (!$this->noExceptionOnNonNullable) {
            $valueType = \gettype($value);
            if ('NULL' === $valueType && false === $type->isNullable()) {
                throw new PropertyNotNullableException($propertyName);
            }
        }

        throw new \Exception('I Fucked up');
    }
}
