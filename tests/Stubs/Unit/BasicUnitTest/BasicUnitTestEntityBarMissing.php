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

namespace Niko9911\JsonToEntity\Tests\Stubs\Unit\BasicUnitTest;

final class BasicUnitTestEntityBarMissing
{
    /**
     * @var int|null
     */
    private $foo;
    /**
     * @var array
     */
    private $fooBar;

    /**
     * BasicUnitTestEntity constructor.
     *
     * @param int   $foo
     * @param array $fooBar
     */
    public function __construct(?int $foo, array $fooBar)
    {
        $this->foo = $foo;
        $this->fooBar = $fooBar;
    }

    /**
     * @return int|null
     */
    public function getFoo(): ?int
    {
        return $this->foo;
    }

    /**
     * @return array
     */
    public function getFooBar(): array
    {
        return $this->fooBar;
    }
}
