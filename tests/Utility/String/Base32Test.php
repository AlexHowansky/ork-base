<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\Utility\String;

use \Ork\Utility\String\Base32;

class Base32Test extends \PHPUnit_Framework_TestCase
{

    public function testEncode()
    {
        $data = 'this is a test do not pass go do not collect $200';
        $encoded = Base32::encode($data);
        $this->assertEquals(
            'ORUGS4ZANFZSAYJAORSXG5BAMRXSA3TPOQQHAYLTOMQGO3ZAMRXSA3TPOQQGG33MNRSWG5BAEQZDAMA',
            $encoded
        );
        $this->assertEquals($data, Base32::decode($encoded));
        $this->assertEquals($data, Base32::decode(strtolower($encoded)));
    }

    /**
     * @expectedException \DomainException
     */
    public function testInvalidLength()
    {
        Base32::decode('123');
    }

    /**
     * @expectedException \DomainException
     */
    public function testInvalidCharacter()
    {
        Base32::decode('1234$');
    }

    /**
     * @expectedException \DomainException
     */
    public function testInvalidPadding()
    {
        Base32::decode('23');
    }

}