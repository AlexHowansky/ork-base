<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Image;

class GravatarTest extends \PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $this->assertEquals(
            'a1719586837f0fdac8835f74cf4ef04a',
            md5((new \Ork\Image\Gravatar(['email' => 'foo@bar.com']))->get())
        );
    }

    public function testUri()
    {
        $img = new \Ork\Image\Gravatar([
            'email' => 'foo@bar.com',
            'defaultUri' => 'http://a.b?c=1&d=2',
            'size' => 64,
        ]);
        $this->assertEquals(
            'http://www.gravatar.com/avatar/f3ada405ce890b6f8204094deb12d8a8.jpg?s=64&d=http%3A%2F%2Fa.b%3Fc%3D1%26d%3D2',
             $img->getUri()
        );
    }

    /**
     * @expectedException \DomainException
     */
    public function testBadSizeSmall()
    {
        new \Ork\Image\Gravatar([
            'size' => '0',
        ]);
    }

    /**
     * @expectedException \DomainException
     */
    public function testBadSizeLarge()
    {
        new \Ork\Image\Gravatar([
            'size' => '513',
        ]);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNoEmail()
    {
        (new \Ork\Image\Gravatar())->getUri();
    }

}