<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Utility;

class ObjectTest extends \PHPUnit_Framework_TestCase
{

    public function testSimple()
    {
        $this->assertEquals('Foo', \Ork\Utility\Object::getBasename('Foo'));
        $this->assertEquals('', \Ork\Utility\Object::getNamespace('Foo'));
    }

    public function testZend()
    {
        $this->assertEquals('Baz', \Ork\Utility\Object::getBasename('Foo_Bar_Baz'));
        $this->assertEquals('Foo_Bar', \Ork\Utility\Object::getNamespace('Foo_Bar_Baz'));
    }

    public function testNamespace()
    {
        $this->assertEquals('Baz', \Ork\Utility\Object::getBasename('\Foo\Bar\Baz'));
        $this->assertEquals('Foo\Bar', \Ork\Utility\Object::getNamespace('\Foo\Bar\Baz'));
    }

    public function testObject()
    {
        $this->assertEquals('stdClass', \Ork\Utility\Object::getBasename(new \stdClass()));
        $this->assertEquals('', \Ork\Utility\Object::getNamespace(new \stdClass()));
    }

    public function testObjectNamespace()
    {
        $this->assertEquals('Writer', \Ork\Utility\Object::getBasename(new \Ork\Csv\Writer()));
        $this->assertEquals('Ork\Csv', \Ork\Utility\Object::getNamespace(new \Ork\Csv\Writer()));
    }

}
