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
 * Because you can't have a class named Class. :(
 */
class Object
{

    /**
     * Get the basename of a class.
     *
     * @param mixed $class The name of a class or an instance of it.
     *
     * @return string The base name of the class.
     */
    public static function getBasename($class)
    {
        if (is_object($class) === true) {
            $class = get_class($class);
        }
        foreach (['\\', '_'] as $separator) {
            $pos = strrpos($class, $separator);
            if ($pos !== false) {
                return substr($class, $pos + 1);
            }
        }
        return $class;
    }

    /**
     * Get the namespace of a class.
     *
     * @param mixed $class The name of a class or an instance of it.
     *
     * @return string The namespace of the class.
     */
    public static function getNamespace($class)
    {
        if (is_object($class) === true) {
            $class = get_class($class);
        }
        foreach (['\\', '_'] as $separator) {
            $pos = strrpos($class, $separator);
            if ($pos !== false) {
                return ltrim(substr($class, 0, $pos), $separator);
            }
        }
        return '';
    }

}
