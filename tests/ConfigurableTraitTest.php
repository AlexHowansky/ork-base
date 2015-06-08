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

class ConfigurableTraitTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyInitialConfig()
    {
        $this->assertObjectNotHasAttribute('config', $this->getObjectForTrait('\\Ork\\ConfigurableTrait'));
    }

    public function testConstructor()
    {
        $configs = [
            'key1' => 'foo',
            'key2' => 'bar',
        ];
        $stub = new Stubs\ConfigurableTraitStub($configs);
        $this->assertEquals($configs, $stub->getConfigs());
    }

    public function testSetScalar()
    {
        $stub = new Stubs\ConfigurableTraitStub();
        $this->assertEquals('value1', $stub->getConfig('key1'));
        $stub->setConfig('key1', 'foo');
        $this->assertEquals('foo', $stub->getConfig('key1'));
    }

    public function testSetArray()
    {
        $configs = [
            'key1' => 'foo',
            'key2' => 'bar',
        ];
        $stub = new Stubs\ConfigurableTraitStub();
        $stub->setConfigs($configs);
        $this->assertEquals($configs, $stub->getConfigs());
    }

    public function testSetTraversable()
    {
        $configs = [
            'key1' => 'foo',
            'key2' => 'bar',
        ];
        $stub = new Stubs\ConfigurableTraitStub();
        $stub->setConfigs(new \ArrayIterator($configs));
        $this->assertEquals($configs, $stub->getConfigs());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testSetInvalidKey()
    {
        $stub = new Stubs\ConfigurableTraitStub();
        $stub->setConfig('badKey', 'badValue');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNotTraversableScalar()
    {
        new Stubs\ConfigurableTraitStub('foo');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNotTraversableObject()
    {
        new Stubs\ConfigurableTraitStub(new \stdClass());
    }

    /**
     * @expectedException \LogicException
     */
    public function testNoConfig()
    {
        new Stubs\ConfigurableTraitBadStub();
    }

}
