<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Csv;

/**
 * CSV writer.
 */
class Writer
{

    use \Ork\ConfigurableTrait;

    /**
     * Configurable trait settings.
     *
     * @var array
     */
    protected $config = [

        // The field delimiter character.
        'delimiter' => ',',

        // The escape character.
        'escape' => '\\',

        // The file to process.
        'file' => 'php://stdout',

        // Write a header row with column names?
        'header' => true,

        // The field quote charater.
        'quote' => '"',

    ];

    /**
     * File handle.
     *
     * @var resource
     */
    protected $csv = null;

    /**
     * Have we output the header row yet?
     *
     * @var boolean
     */
    protected $headerOutput = false;

    /**
     * Make sure the file handle is closed.
     */
    public function __destruct()
    {
        if (is_resource($this->csv) === true) {
            fclose($this->csv);
        }
    }

    /**
     * Write a row to the file.
     *
     * @param array $row The row to write.
     *
     * @return int The length of the line written.
     * @throws \RuntimeException On error.
     */
    protected function put(array $row)
    {
        $result = fputcsv(
            $this->csv,
            $row,
            $this->getConfig('delimiter'),
            $this->getConfig('quote'),
            $this->getConfig('escape')
        );
        if ($result === false) {
            throw new \RuntimeException('Unable to write to output file.');
        }
        return $result;
    }

    /**
     * Write a row to the file.
     *
     * @param array $row The row to write.
     *
     * @return int The length of the line written.
     * @throws \RuntimeException On error.
     */
    public function write(array $row)
    {

        // Open the file if it's not already open.
        if ($this->csv === null) {
            $csv = fopen($this->getConfig('file'), 'w');
            if (is_resource($csv) === false) {
                throw new \RuntimeException('Unable to open output file.');
            }
            $this->csv = $csv;
        }

        // Output the header row if we haven't already.
        if ($this->headerOutput === false && $this->getConfig('header') === true) {
            $this->put(array_keys($row));
            $this->headerOutput = true;
        }

        $this->put(array_values($row));

    }

}
