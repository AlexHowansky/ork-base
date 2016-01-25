<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Filter;

/**
 * Converts a string to a timestamp.
 */
class StringToTime implements FilterInterface
{

    use \Ork\ConfigurableTrait;

    /**
     * Configurable trait settings.
     *
     * @var array
     */
    protected $config = [

        // Allow SQL strings like 'now()' and 'CURRENT_TIMESTAMP'
        'allowSqlSpecials' => false,

    ];

    /**
     * Convert a string to a timestamp.
     *
     * @param string $value A string to convert to a timestamp.
     *
     * @return integer The converted timestamp.
     */
    public function filter($value)
    {

        // If it's already a timestamp, return it as is.
        if (preg_match('/^-?\d+$/', $value) === 1) {
            if ($value < 0) {
                throw new \DomainException('Invalid value');
            }
            return $value;
        }

        // Allow SQL specials.
        if ($this->getConfig('allowSqlSpecials') === true) {
            $temp = strtolower($value);
            if ($temp === 'now()' || $temp === 'current_timestamp') {
                return time();
            }
        }

        // Catch invalid strings.
        $time = strtotime($value);
        if ($time === false) {
            throw new \DomainException('Invalid value');
        }

        return $time;

    }

}
