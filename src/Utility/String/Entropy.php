<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Utility\String;

/**
 * Calculate the Shannon entropy of a string.
 *
 * This can be used to determine the "strength" of user-provided passwords.
 */
class Entropy
{

    /**
     * Calculate the total number of bits of entropy provided by the string.
     *
     * @param string $string The string to calculate the entropy of.
     *
     * @return int The total number of bits of entropy provided by the string.
     */
    public static function bits($string)
    {
        return self::bitsPerCharacter($string) * strlen($string);
    }

    /**
     * Calculate the number of bits needed to encode a single character of the given string.
     *
     * @param string $string The string to calculate the entropy of.
     *
     * @return int The number of bits of entropy needed to encode a single character of the given string.
     */
    public static function bitsPerCharacter($string)
    {
        if (is_string($string) === false) {
            throw new \InvalidArgumentException('Argument must be a string.');
        }
        $sum = 0;
        $length = strlen($string);
        foreach (array_values(array_count_values(str_split($string))) as $count) {
            $freq = $count / $length;
            $sum += $freq * log($freq, 2);
        }
        return (int) ceil(- $sum);
    }

}
