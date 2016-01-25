<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Image;

/**
 * Generates inline HTML image markup from image files.
 */
class Inline
{

    /**
     * Any extra HTML attributes to create the IMG tag with.
     *
     * @var string
     */
    protected $extraHtml = null;

    /**
     * The string blob.
     *
     * @var string
     */
    protected $image = null;

    /**
     * The MIME type of the image.
     *
     * @var string
     */
    protected $mimeType = 'image/jpg';

    /**
     * Allow the object to be referenced as a string.
     *
     * @return string The image encoded as an inline IMG tag.
     */
    public function __toString()
    {
        try {
            return $this->encode();
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Encode the current image as an inline IMG tag.
     *
     * @return string The image encoded as an inline IMG tag.
     */
    public function encode()
    {
        if (empty($this->image) === true) {
            throw new \RuntimeException('No source image has been specified.');
        }
        $str = '<img src="data:' . $this->mimeType . ';base64,' . base64_encode($this->image) . '"';
        if (empty($this->extraHtml) === false) {
            $str .= ' ' . trim($this->extraHtml);
        }
        $str .= ' />';
        return $str;
    }

    /**
     * Get the extra HTML attributes to be used for this IMG tag.
     *
     * @return string The extra HTML attributes to be used for this IMG tag.
     */
    public function getExtraHtml()
    {
        return $this->extraHtml;
    }

    /**
     * Get the image blob.
     *
     * @return string The image blob.
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get the MIME type for this image.
     *
     * @return string The MIME type for this image.
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set the extra HTML attributes to be used for this IMG tag.
     *
     * @param string $extraHtml The extra HTML attributes.
     *
     * @return \Ork\Image\Inline Allow method chaining.
     */
    public function setExtraHtml($extraHtml)
    {
        $this->extraHtml = $extraHtml;
        return $this;
    }

    /**
     * Set the image source from a string.
     *
     * @param string $blob The image.
     *
     * @return \Ork\Image\Inline Allow method chaining.
     */
    public function setImageFromBlob($blob)
    {
        $this->image = $blob;
        return $this;
    }

    /**
     * Set the image source from a file.
     *
     * @param string $file The image file.
     *
     * @return \Ork\Image\Inline Allow method chaining.
     */
    public function setImageFromFile($file)
    {
        if (preg_match('/\.([^\.]+)$/', $file, $match) === 1) {
            $this->setMimeType('image/' . $match[1]);
        }
        return $this->setImageFromBlob(file_get_contents($file));
    }

    /**
     * Set the MIME type for this image.
     *
     * @param string $mimeType The MIME type.
     *
     * @return \Ork\Image\Inline Allow method chaining.
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

}
