<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Image;

class Gravatar
{

    use \Ork\ConfigurableTrait;

    /**
     * Configurable trait settings.
     *
     * @var array
     */
    protected $config = [

        // The default image URI to use if none is available for the requested email.
        'defaultUri' => null,

        // The email address to get the gravatar for.
        'email' => null,

        // The requested image size.
        'size' => null,

    ];

    /**
     * Validate the requested image size.
     *
     * @param int $size The image size to set.
     *
     * @return int
     */
    protected function filterConfigSize($size)
    {
        if ($size < 1 || $size > 512) {
            throw new \DomainException('Size must be between 1 and 512.');
        }
        return $size;
    }

    /**
     * Get the gravatar image.
     *
     * @return string
     */
    public function get()
    {
        return file_get_contents($this->getUri());
    }

    /**
     * Get the gravatar URI.
     *
     * @return string The gravatar URI.
     */
    public function getUri()
    {
        if (empty($this->getConfig('email')) === true) {
            throw new \RuntimeException('No email specified.');
        }
        $uri = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->getConfig('email')))) . '.jpg';
        $args = http_build_query([
            's' => $this->getConfig('size'),
            'd' => $this->getConfig('defaultUri'),
        ]);
        if (empty($args) === false) {
            $uri .= '?' . $args;
        }
        return $uri;
    }

}
