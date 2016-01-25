<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Image;

class InlineTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetMimeType()
    {
        $image = new \Ork\Image\Inline();
        $this->assertEquals('image/jpg', $image->getMimeType());
        $image->setMimeType('foo');
        $this->assertEquals('foo', $image->getMimeType());
    }

    public function testSetGetExtraHtml()
    {
        $image = new \Ork\Image\Inline();
        $this->assertNull($image->getExtraHtml());
        $image->setExtraHtml('foo');
        $this->assertEquals('foo', $image->getExtraHtml());
    }

    public function testImage()
    {
        $hash = '0238e04497807757b13551eb985215a4';
        $blob = file_get_contents(__DIR__ . '/Fixtures/accept.png');
        $image = new \Ork\Image\Inline();
        $image->setImageFromFile(__DIR__ . '/Fixtures/accept.png');
        $this->assertEquals($blob, $image->getImage());
        $this->assertEquals($hash, md5((string) $image));
        $image->setImageFromBlob($blob);
        $this->assertEquals($blob, $image->getImage());
        $this->assertEquals($hash, md5((string) $image));
    }

    public function testExtraHtml()
    {
        $image = new \Ork\Image\Inline();
        $image->setImageFromFile(__DIR__ . '/Fixtures/accept.png');
        $image->setExtraHtml('class="foo"');
        $this->assertEquals('1a2e705efa7ed60cccdf83f64f1d2278', md5((string) $image));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNoImage()
    {
        (new \Ork\Image\Inline())->encode();
    }

    public function testNoImageString()
    {
        $this->assertEquals('', (string) new \Ork\Image\Inline());
    }

}
