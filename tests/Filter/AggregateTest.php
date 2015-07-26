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

class AggregateTest extends \PHPUnit_Framework_TestCase
{

    public function testFilters()
    {
        $aggregate = new \Ork\Filter\Aggregate([
            new \Ork\Filter\State\NameToAbbreviation(),
            new \Ork\Filter\State\AbbreviationToName(),
        ]);
        $this->assertEquals('New York', $aggregate->filter('new york'));
    }

    public function testIterator()
    {
        $aggregate = new \Ork\Filter\Aggregate([
            new \Ork\Filter\State\NameToAbbreviation(),
            new \Ork\Filter\State\AbbreviationToName(),
        ]);
        foreach ($aggregate as $filter) {
            $this->assertInstanceOf('\Ork\Filter\FilterInterface', $filter);
        }
    }

}
