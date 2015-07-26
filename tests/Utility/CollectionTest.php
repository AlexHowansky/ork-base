<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Utility;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    public function testGetFirstNonEmptyElement()
    {
        $this->assertEquals('foo', \Ork\Utility\Collection::getFirstNonEmptyElement([null, null, 'foo']));
    }

    public function testGetFirstNonEmptyElementDefault()
    {
        $this->assertEquals('foo', \Ork\Utility\Collection::getFirstNonEmptyElement([null, null, null], 'foo'));
    }

    public function testGetFirstNonEmptyElementNoDefault()
    {
        $this->assertEquals(null, \Ork\Utility\Collection::getFirstNonEmptyElement([null, null, null]));
    }

    public function testInCsv()
    {
        $this->assertTrue(\Ork\Utility\Collection::inCsv('bar', 'foo,bar,baz'));
        $this->assertFalse(\Ork\Utility\Collection::inCsv('wat', 'foo,bar,baz'));
    }

    public function testInCsvDelimiter()
    {
        $this->assertTrue(\Ork\Utility\Collection::inCsv('bar', '#foo#|#bar#|#baz#', '|', '#'));
    }

}