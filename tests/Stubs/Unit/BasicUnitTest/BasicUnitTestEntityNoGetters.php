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

final class BasicUnitTestEntityNoGetters
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
     * @return array
     */
    public function toArray(): array
    {
        return
        [
            'bar'    => $this->bar,
            'foo'    => $this->foo,
            'fooBar' => $this->fooBar,
        ];
    }
}
