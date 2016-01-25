<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Stubs;

class ConfigurableTraitStub
{

    use \Ork\ConfigurableTrait;

    protected $config = [
        'key1' => 'value1',
        'key2' => null,
        'key3' => null,
        'key4' => null,
    ];

    protected function filterConfigKey3($value)
    {
        if ($value) {
            throw new \DomainException('Invalid value.');
        }
        return $value;
    }

    protected function filterConfigKey4($value)
    {
        return strtoupper($value);
    }

}
