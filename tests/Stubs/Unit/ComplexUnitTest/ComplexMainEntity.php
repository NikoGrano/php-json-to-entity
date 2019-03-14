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

namespace Niko9911\JsonToEntity\Tests\Stubs\Unit\ComplexUnitTest;

final class ComplexMainEntity
{
    /**
     * @var ComplexSubEntity
     */
    private $subEntity;
    /**
     * @var array
     */
    private $simple;
    /**
     * @var array
     */
    private $complex;

    public function __construct(ComplexSubEntity $subEntity, array $simple, array $complex)
    {
        $this->subEntity = $subEntity;
        $this->simple = $simple;
        $this->complex = $complex;
    }

    /**
     * @return ComplexSubEntity
     */
    public function getSubEntity(): ComplexSubEntity
    {
        return $this->subEntity;
    }

    /**
     * @return array
     */
    public function getSimple(): array
    {
        return $this->simple;
    }

    /**
     * @return array
     */
    public function getComplex(): array
    {
        return $this->complex;
    }
}
