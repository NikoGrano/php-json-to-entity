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

final class ComplexSubEntity
{
    /**
     * @var ComplexSubSubEntity
     */
    private $subSubEntity;
    /**
     * @var float
     */
    private $worthiness;
    /**
     * @var bool
     */
    private $processed;

    public function __construct(ComplexSubSubEntity $subSubEntity, float $worthiness, bool $processed)
    {
        $this->subSubEntity = $subSubEntity;
        $this->worthiness = $worthiness;
        $this->processed = $processed;
    }

    /**
     * @return ComplexSubSubEntity
     */
    public function getSubSubEntity(): ComplexSubSubEntity
    {
        return $this->subSubEntity;
    }

    /**
     * @return float
     */
    public function getWorthiness(): float
    {
        return $this->worthiness;
    }

    /**
     * @return bool
     */
    public function isProcessed(): bool
    {
        return $this->processed;
    }
}
