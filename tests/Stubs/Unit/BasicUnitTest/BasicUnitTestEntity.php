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

final class BasicUnitTestEntity
{
    /**
     * @var string
     */
    private $bar;
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
     * @param string $bar
     * @param int    $foo
     * @param array  $fooBar
     */
    public function __construct(string $bar, ?int $foo, array $fooBar)
    {
        $this->bar = $bar;
        $this->foo = $foo;
        $this->fooBar = $fooBar;
    }

    /**
     * @return string
     */
    public function getBar(): string
    {
        return $this->bar;
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
