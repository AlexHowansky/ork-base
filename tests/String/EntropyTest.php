<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests;

class EntropyTest extends \PHPUnit_Framework_TestCase
{

    public function testString()
    {
        $entropy = new \Ork\String\Entropy();
        $this->assertEquals(4, $entropy->bitsPerCharacter('Tr0ub4dor&3'));
        $this->assertEquals(44, $entropy->bits('Tr0ub4dor&3'));
        $this->assertEquals(4, $entropy->bitsPerCharacter('correcthorsebatterystaple'));
        $this->assertEquals(100, $entropy->bits('correcthorsebatterystaple'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFail()
    {
        $entropy = new \Ork\String\Entropy();
        $entropy->bits(1);
    }

}