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

namespace Niko9911\JsonToEntity\Domain\Exception;

final class PropertyNotNullableException extends Exception
{
    /**
     * @var string
     */
    private $property;

    public function __construct(string $property)
    {
        $this->property = $property;
        parent::__construct("Property $property is not nullable!");
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }
}
