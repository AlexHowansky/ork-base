<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Filter;

class StringToTimeTest extends \PHPUnit_Framework_TestCase
{

    protected $filter = null;

    public function setup()
    {
        $this->filter = new \Ork\Filter\StringToTime();
        $this->assertFalse($this->filter->getConfig('allowSqlSpecials'));
    }

    /**
     * Test a valid string.
     */
    public function testValid()
    {
        $this->assertEquals(1278239520, $this->filter->filter('July 4th 2010 6:32am EDT'));
    }

    /*
     * Test an existing timestamp.
     */
    public function testTimestamp()
    {
        $now = time();
        $this->assertEquals($now, $this->filter->filter($now));
    }

    /**
     * Verify that SQL strings fail when the configuration option is off.
     *
     * @expectedException \DomainException
     */
    public function testSqlOff()
    {
        $this->filter->setConfig('allowSqlSpecials', false);
        $this->filter->filter('CURRENT_TIMESTAMP');
    }

    /**
     * Test the special SQL strings.
     */
    public function testSqlOn()
    {
        $this->filter->setConfig('allowSqlSpecials', true);
        $this->assertEquals(time(), $this->filter->filter('now()'), null, 1);
        $this->assertEquals(time(), $this->filter->filter('CURRENT_TIMESTAMP'), null, 1);
        $this->assertEquals(1278239520, $this->filter->filter('July 4th 2010 6:32am EDT'));
    }

    /**
     * Test failure on an invalid string.
     *
     * @expectedException \DomainException
     */
    public function testFailure()
    {
        $this->filter->filter('blarg');
    }

    /**
     * Test failure on an invalid timestamp.
     *
     * @expectedException \DomainException
     */
    public function testNegativeFailure()
    {
        $this->filter->filter(-1);
    }

}
