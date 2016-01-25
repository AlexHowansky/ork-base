<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Utility;

/**
 * Because you can't have a class named List or Array. :(
 */
class Collection
{

    /**
     * Get the first non-empty element of a list.
     *
     * @param array $list    The list to scan.
     * @param mixed $default If no non-empty element is found, return this value.
     *
     * @return mixed The first non-empty element in the list.
     */
    public static function getFirstNonEmptyElement($list, $default = null)
    {
        foreach ($list as $item) {
            if (empty($item) === false) {
                return $item;
            }
        }
        return $default;
    }

    /**
     * Is an item in a CSV-formatted string list?
     *
     * @param string $item      The item to scan for.
     * @param string $list      The list to scan.
     * @param type   $delimiter The delimiter character to use.
     * @param type   $enclosure The enclosure character to use.
     * @param type   $escape    The escape character to use.
     *
     * @return boolean True if the item is in the list.
     */
    public static function inCsv($item, $list, $delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        return in_array($item, str_getcsv($list, $delimiter, $enclosure, $escape));
    }

}
