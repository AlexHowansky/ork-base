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

use org\bovigo\vfs\vfsStream;

class ConfigurableTraitTest extends \PHPUnit_Framework_TestCase
{

    protected $configs = [
        'key1' => 'foo',
        'key2' => 'bar',
    ];

    public function testEmptyInitialConfig()
    {
        $this->assertObjectNotHasAttribute('config', $this->getObjectForTrait('\\Ork\\ConfigurableTrait'));
    }

    public function testConstructorTravsersable()
    {
        $stub = new Stubs\ConfigurableTraitStub($this->configs);
        $this->assertEquals($this->configs, $stub->getConfigs());
    }

    public function testConstructorFile()
    {
        $vfs = vfsStream::setup();
        $file = $vfs->url() . '/config.json';
        file_put_contents($file, json_encode($this->configs));
        $stub = new Stubs\ConfigurableTraitStub($file);
        $this->assertEquals($this->configs, $stub->getConfigs());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorInteger()
    {
        new Stubs\ConfigurableTraitStub(1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorNotTraversableObject()
    {
        new Stubs\ConfigurableTraitStub(new \stdClass());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructorNoFile()
    {
        $vfs = vfsStream::setup();
        new Stubs\ConfigurableTraitStub($vfs->url() . '/path/to/bad/file');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructorBadFile()
    {
        $vfs = vfsStream::setup();
        $file = $vfs->url() . '/config.json';
        file_put_contents($file, 'fail');
        new Stubs\ConfigurableTraitStub($file);
    }

    /**
     * @expectedException \LogicException
     */
    public function testNoConfigDefined()
    {
        new Stubs\ConfigurableTraitBadStub();
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
        $stub = new Stubs\ConfigurableTraitStub();
        $stub->setConfigs($this->configs);
        $this->assertEquals($this->configs, $stub->getConfigs());
    }

    public function testSetTraversable()
    {
        $stub = new Stubs\ConfigurableTraitStub();
        $stub->setConfigs(new \ArrayIterator($this->configs));
        $this->assertEquals($this->configs, $stub->getConfigs());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testSetInvalidKey()
    {
        $stub = new Stubs\ConfigurableTraitStub();
        $stub->setConfig('badKey', 'badValue');
    }

}
