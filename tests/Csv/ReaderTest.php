<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Csv;

class ReaderTest extends \PHPUnit_Framework_TestCase
{

    public function reverse($value)
    {
        return strrev($value);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMissingFile()
    {
        $csv = new \Ork\Csv\Reader([
            'file' => __DIR__ . '/Fixtures/missingFile.csv',
        ]);
        @$csv->toArray();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testBadFile()
    {
        $csv = new \Ork\Csv\Reader([
            'file' => __DIR__ . '/Fixtures/badFile.csv',
        ]);
        $csv->toArray();
    }

    public function testHeaderlessFile()
    {
        $csv = new \Ork\Csv\Reader([
            'file' => __DIR__ . '/Fixtures/headerlessFile.csv',
            'header' => false,
        ]);
        $this->assertEquals([[1,2,3,4,5], [6,7,8,9,10]], $csv->toArray());
    }

    public function testHeaderFile()
    {
        $csv = new \Ork\Csv\Reader([
            'file' => __DIR__ . '/Fixtures/headerFile.csv',
            'header' => true,
        ]);
        $this->assertEquals([
            '1' => ['Id' => 1, 'Name' => 'Foo', 'Number' => 37],
            '2' => ['Id' => 2, 'Name' => 'Bar', 'Number' => 142],
            '3' => ['Id' => 3, 'Name' => 'Baz', 'Number' => 71],
        ], $csv->toArray('Id'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMismatchFile()
    {
        $csv = new \Ork\Csv\Reader([
            'file' => __DIR__ . '/Fixtures/mismatchFile.csv',
            'header' => true,
        ]);
        $csv->toArray();
    }

    public function testCallbacks()
    {
        $csv = new \Ork\Csv\Reader([
            'file' => __DIR__ . '/Fixtures/callbacksFile.csv',
            'header' => true,
            'callbacks' => [
                'Name' => ['strtolower', 'trim', [$this, 'reverse']],
            ],
        ]);
        $this->assertEquals([
            '1' => ['Id' => 1, 'Name' => 'oof'],
            '2' => ['Id' => 2, 'Name' => 'rab'],
            '3' => ['Id' => 3, 'Name' => 'zab'],
        ], $csv->toArray('Id'));
    }

    public function testLineCount()
    {
        $csv = new \Ork\Csv\Reader([
            'file' => __DIR__ . '/Fixtures/headerFile.csv',
            'header' => true,
        ]);
        $expected = 2;
        foreach ($csv as $row) {
            $this->assertEquals($expected++, $csv->getLineNumber());
        }
    }

}
