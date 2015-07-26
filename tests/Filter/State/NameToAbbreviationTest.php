<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Filter\State;

class NameToAbbreviationTest extends \PHPUnit_Framework_TestCase
{

    public function testGood()
    {
        $filter = new \Ork\Filter\State\NameToAbbreviation();
        $this->assertEquals('NY', $filter->filter('new york'));
    }

    public function testTrim()
    {
        $filter = new \Ork\Filter\State\NameToAbbreviation();
        $this->assertEquals('NY', $filter->filter(' new  york   '));
    }

    public function testBad()
    {
        $filter = new \Ork\Filter\State\NameToAbbreviation();
        $this->assertEquals('foo', $filter->filter('foo'));
    }

    public function testDefaultConfig()
    {
        $filter = new \Ork\Filter\State\NameToAbbreviation();
        $this->assertEquals(false, $filter->getConfig('includeTerritories'));
        $this->assertEquals('Puerto Rico', $filter->filter('Puerto Rico'));
    }

    public function testTerritory()
    {
        $filter = new \Ork\Filter\State\NameToAbbreviation([
            'includeTerritories' => true,
        ]);
        $this->assertEquals('PR', $filter->filter('Puerto Rico'));
    }

}
