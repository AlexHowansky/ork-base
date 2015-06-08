<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
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
    ];

}
