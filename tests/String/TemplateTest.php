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

class TemplateTest extends \PHPUnit_Framework_TestCase
{

    public function testTemplate()
    {
        $template = new \Ork\String\Template(['template' => 'this {is} a {test}']);
        $this->assertEquals('this foo a bar', $template->apply(['is' => 'foo', 'test' => 'bar']));
    }

}
