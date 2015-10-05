<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\String;

/**
 * Simple template expander.
 *
 * <code>
 * $template = new \Ork\String\Template('The email of {name} is {email}');
 * $data = [
 *     'name' => 'Joe Smith',
 *     'email' => 'joe@devnull.com',
 * ];
 * $result = $template->apply($data);
 * </code>
 */
class Template
{

    use \Ork\ConfigurableTrait;

    /**
     * Configurable trait settings.
     *
     * @var array
     */
    protected $config = [

        // The template to use.
        'template' => null,

    ];

    /**
     * Apply a data set to the template.
     *
     * @param array $params The data set.
     *
     * @return string The filled-out template.
     */
    public function apply(array $params)
    {
        $tags = [];
        foreach ($params as $key => $value) {
            $tags['/{' . $key . '}/'] = $value;
        }
        return preg_replace(array_keys($tags), array_values($tags), $this->getConfig('template'));
    }

}
