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

class AbbreviationToNameTest extends \PHPUnit_Framework_TestCase
{

    public function testGood()
    {
        $filter = new \Ork\Filter\State\AbbreviationToName();
        $this->assertEquals('New York', $filter->filter('ny'));
    }

    public function testTrim()
    {
        $filter = new \Ork\Filter\State\AbbreviationToName();
        $this->assertEquals('New York', $filter->filter(' ny '));
    }

    public function testBad()
    {
        $filter = new \Ork\Filter\State\AbbreviationToName();
        $this->assertEquals('foo', $filter->filter('foo'));
    }

    public function testDefaultConfig()
    {
        $filter = new \Ork\Filter\State\AbbreviationToName();
        $this->assertEquals(false, $filter->getConfig('includeTerritories'));
        $this->assertEquals('PR', $filter->filter('PR'));
    }

    public function testTerritory()
    {
        $filter = new \Ork\Filter\State\AbbreviationToName([
            'includeTerritories' => true,
        ]);
        $this->assertEquals('Puerto Rico', $filter->filter('PR'));
    }

}
