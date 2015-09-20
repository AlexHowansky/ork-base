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
 * Class to perform base32 encoding/decoding.
 *
 * Base32 encoding can be useful in cases where one might normally
 * use base64 but a case-insensitive result is needed.
 */
class Base32
{

    // via RFC 4648
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * Decode a base32 string.
     *
     * @param string $data The string to decode.
     *
     * @return string The decoded string.
     */
    public static function decode($data)
    {

        // Make sure we have a valid data string.
        $mod = strlen($data) % 8;
        if ($mod === 1 || $mod === 3 || $mod === 6) {
            throw new \DomainException('Invalid input.');
        }

        // Convert the data to a binary string.
        $bits = '';
        foreach (str_split(strtoupper($data)) as $char) {
            $index = strpos(self::ALPHABET, $char);
            if ($index === false) {
                throw new \DomainException('Invalid character in input.');
            }
            $bits .= sprintf('%05b', $index);
        }

        // Make sure padding is all zeroes.
        if (preg_match('/[^0]/', substr($bits, 0 - strlen($bits) % 8)) === 1) {
            throw new \DomainException('Invalid input.');
        }

        // Decode the binary string.
        $output = '';
        foreach (str_split($bits, 8) as $chunk) {
            $output .= chr(bindec($chunk));
        }
        return rtrim($output);

    }

    /**
     * Base32 encode a string.
     *
     * @param string $data The string to encode.
     *
     * @return string The base32 encoded string.
     */
    public static function encode($data)
    {

        // Convert the data to a binary string.
        $bits = '';
        foreach (str_split($data) as $char) {
            $bits .= sprintf('%08b', ord($char));
        }

        // Make sure the string length is a multiple of 5, padding if needed.
        $len = strlen($bits);
        $mod = $len % 5;
        if ($mod !== 0) {
            $bits = str_pad($bits, $len + 5 - $mod, '0', STR_PAD_RIGHT);
        }

        // Split the binary string into 5-bit chunks and encode each chunk.
        $output = '';
        foreach (str_split($bits, 5) as $chunk) {
            $output .= substr(self::ALPHABET, bindec($chunk), 1);
        }

        return $output;

    }

}
