<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Tests\String;

class Base32Test extends \PHPUnit_Framework_TestCase
{

    public function testDefaultEncode()
    {
        $b32 = new \Ork\String\Base32();
        $data = 'this is a test do not pass go do not collect $200';
        $encoded = $b32->encode($data);
        $this->assertEquals(
            'ORUGS4ZANFZSAYJAORSXG5BAMRXSA3TPOQQHAYLTOMQGO3ZAMRXSA3TPOQQGG33MNRSWG5BAEQZDAMA',
            $encoded
        );
        $this->assertEquals($data, $b32->decode($encoded));
        $this->assertEquals($data, $b32->decode(strtolower($encoded)));
    }

    public function testCustomAlphabet()
    {
        $b32 = new \Ork\String\Base32();
        $b32->setConfig('alphabet', '0123456789~!@#$%^&*()-+=[]{};:<>');
        $data = 'this is a test do not pass go do not collect $200';
        $encoded = $b32->encode($data);
        $this->assertEquals(
            '$&)6*;]0#5]*0[90$&*=6:10@&=*0}(%$^^70[!($@^6$}]0@&=*0}(%$^^66}}@#&*+6:104^]30@0',
            $encoded
        );
        $this->assertEquals($data, $b32->decode($encoded));
        $this->assertEquals($data, $b32->decode(strtolower($encoded)));
    }

    /**
     * @expectedException \DomainException
     */
    public function testBadAlphabet()
    {
        $b32 = new \Ork\String\Base32();
        $b32->setConfig('alphabet', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234566');
    }

    /**
     * @expectedException \DomainException
     */
    public function testInvalidLength()
    {
        $b32 = new \Ork\String\Base32();
        $b32->decode('123');
    }

    /**
     * @expectedException \DomainException
     */
    public function testInvalidCharacter()
    {
        $b32 = new \Ork\String\Base32();
        $b32->decode('1234$');
    }

    /**
     * @expectedException \DomainException
     */
    public function testInvalidPadding()
    {
        $b32 = new \Ork\String\Base32();
        $b32->decode('23');
    }

}