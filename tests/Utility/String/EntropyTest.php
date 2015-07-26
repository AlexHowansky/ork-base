<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Utility\String;

class EntropyTest extends \PHPUnit_Framework_TestCase
{

    public function testString()
    {
        $this->assertEquals(4, \Ork\Utility\String\Entropy::bitsPerCharacter('Tr0ub4dor&3'));
        $this->assertEquals(44, \Ork\Utility\String\Entropy::bits('Tr0ub4dor&3'));
        $this->assertEquals(4, \Ork\Utility\String\Entropy::bitsPerCharacter('correcthorsebatterystaple'));
        $this->assertEquals(100, \Ork\Utility\String\Entropy::bits('correcthorsebatterystaple'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFail()
    {
        \Ork\Utility\String\Entropy::bits(1);
    }

}