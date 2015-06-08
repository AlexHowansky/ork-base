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

class WriterTest extends \PHPUnit_Framework_TestCase
{

    protected function getFile()
    {
        return __DIR__ . '/Fixtures/write.csv';
    }

    protected function clean()
    {
        if (file_exists($this->getFile())) {
            unlink($this->getFile());
        }
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testWriteFail()
    {
        $csv = new \Ork\Csv\Writer([
            'file' => '/path/to/file/that/could/not/possibly/exist',
            'header' => false,
        ]);
        @$csv->write([1,2,3,4,5]);
    }

    public function testWriteNoHeader()
    {
        $this->clean();
        $csv = new \Ork\Csv\Writer([
            'file' => $this->getFile(),
            'header' => false,
        ]);
        $csv->write([1,2,3,4,5]);
        $csv->write([6,7,8,9,10]);
        unset($csv);
        $this->assertEquals('66f1d63c002cde9257adc36a7ed58c31', md5_file($this->getFile()));
    }

    public function testWriteHeader()
    {
        $this->clean();
        $csv = new \Ork\Csv\Writer([
            'file' => $this->getFile(),
            'header' => true,
        ]);
        $csv->write([
            'Id' => 1,
            'Name' => 'foo',
        ]);
        $csv->write([
            'Id' => 2,
            'Name' => 'bar',
        ]);
        $csv->write([
            'Id' => 3,
            'Name' => 'baz',
        ]);
        unset($csv);
        $this->assertEquals('2fc774926f1155e3f70065241680043e', md5_file($this->getFile()));
    }

}
