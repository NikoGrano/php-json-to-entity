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

final class ValueCannotBeCastedToRequestedTypeException extends Exception
{
    /**
     * @var string
     */
    private $property;
    /**
     * @var string
     */
    private $jsonKey;
    /**
     * @var string
     */
    private $type;
    private $value;

    /**
     * ValueCannotBeCastedToRequestedTypeException constructor.
     *
     * @param string $property
     * @param string $jsonKey
     * @param string $type
     * @param mixed  $value
     * @param string $msg
     */
    public function __construct(string $property, string $jsonKey, string $type, $value, string $msg = '')
    {
        parent::__construct("Cannot cast $property to $type. $msg");
        $this->property = $property;
        $this->jsonKey = $jsonKey;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @return string
     */
    public function getJsonKey(): string
    {
        return $this->jsonKey;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
