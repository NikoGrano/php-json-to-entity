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
 * Class Strings.
 *
 * @internal
 */
final class Strings
{
    /**
     * Removes - and _ and makes the next letter uppercase.
     *
     * @param string $name Property name
     *
     * @return string CamelCasedVariableName
     *
     * @internal
     */
    private static function getCamelCaseName(string $name): string
    {
        return \lcfirst(
            \str_replace(
                ' ',
                '',
                \ucwords(\str_replace(['_', '-'], ' ', $name))
            )
        );
    }

    /**
     * Since hyphens cannot be used in variables we have to uppercase them.
     *
     * Technically you may use them, but they are awkward to access.
     *
     * @param string $name Property name
     *
     * @return string Name without hyphen
     *
     * @internal
     */
    public static function getSafeName(string $name): string
    {
        if (false !== \mb_strpos($name, '-')) {
            $name = self::getCamelCaseName($name);
        }

        return $name;
    }
}
