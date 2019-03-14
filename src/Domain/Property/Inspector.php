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

namespace Niko9911\JsonToEntity\Domain\Property;

use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Niko9911\JsonToEntity\Domain\Exception\PropertyUndefinedException;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class Reflection.
 *
 * @internal
 */
class Inspector
{
    /**
     * Runtime cache for reflected classes.
     *
     * @var Type[][]
     */
    protected static $reflectedClassesCache = [];

    /**
     * @param \ReflectionClass $class
     * @param string           $key
     *
     * @return Type
     *
     * @throws PropertyUndefinedException
     *
     * @internal
     */
    public static function getReflectedProperty(\ReflectionClass $class, string $key): Type
    {
        $name = $class->getName();
        if (!isset(self::$reflectedClassesCache[$name][$key])) {
            self::$reflectedClassesCache[$name][$key] = static::getClassPropertyType($class, $key);
        }

        return self::$reflectedClassesCache[$name][$key];
    }

    /**
     * @param string $className
     *
     * @return Type<string>[]
     *
     * @internal
     */
    public static function getAllPropertiesWithTypes(string $className): array
    {
        $extractor = self::getSymfonyExtractor();
        $properties = $extractor->getProperties($className);
        $returnValues = [];

        foreach ($properties as $property) {
            $returnValues[$property] = $extractor->getTypes($className, $property)[0];
        }

        return $returnValues;
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @param \ReflectionClass|bool $class
     * @param string                $propertyName
     *
     * @return Type
     *
     * @throws PropertyUndefinedException
     */
    protected static function getClassPropertyType(\ReflectionClass $class, string $propertyName): Type
    {
        $extractor = self::getSymfonyExtractor();
        $name = $class->getName();
        $properties = $extractor->getProperties($class->getName());

        if (null === $properties) {
            throw new PropertyUndefinedException(
                "Property $propertyName is not declared in $name. 
                NOTE: You need also getters for properties. This is intended behavior due Symfony PropertyInfo library."
            );
        }

        $propertiesFlip = \array_flip($properties);

        if (!isset($propertiesFlip[$propertyName])) {
            foreach ($properties as $key => $property) {
                if (0 === \strcasecmp($property, $propertyName)) {
                    // Currently this is fallback, if some reason Symfony breaks.
                    // Not testable and is only long shot, if something break in deps.
                    // @codeCoverageIgnoreStart
                    $foundKey = $key;
                    break;
                    // @codeCoverageIgnoreEnd
                }
            }
        } else {
            $foundKey = $propertiesFlip[$propertyName];
        }

        if (!isset($foundKey)) {
            throw new PropertyUndefinedException("Property $propertyName doesnt exist in $name.");
        }

        // This exception should be impossible due checks.
        /* @noinspection PhpUnhandledExceptionInspection */
        return $extractor->getTypes($class->getName(), $properties[$foundKey])[0];
    }

    /**
     * @return PropertyInfoExtractor
     */
    protected static function getSymfonyExtractor(): PropertyInfoExtractor
    {
        $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();
        $listExtractors = [$reflectionExtractor];
        $typeExtractors = [$phpDocExtractor, $reflectionExtractor];
        $descriptionExtractors = [$phpDocExtractor];
        $accessExtractors = [$reflectionExtractor];
        $propertyInitializeExtractors = [$reflectionExtractor];

        return new PropertyInfoExtractor(
            $listExtractors,
            $typeExtractors,
            $descriptionExtractors,
            $accessExtractors,
            $propertyInitializeExtractors
        );
    }
}
