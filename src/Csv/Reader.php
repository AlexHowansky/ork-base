<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Csv;

/**
 * CSV reader.
 */
class Reader implements \IteratorAggregate
{

    use \Ork\ConfigurableTrait;

    /**
     * Contains the column names from the header row.
     *
     * @var array
     */
    protected $columns = null;

    /**
     * Configurable trait settings.
     *
     * @var array
     */
    protected $config = [

        /**
         * Callback functions to run on the values after they're extracted. If using a header row,
         * the array index should be the name of the field to apply callbacks to. Alternatively,
         * if the index string begins with a slash, it will be treated as a regex and applied to
         * all matching fields. If not using a header row, the array index should be the numerical
         * index of the column to apply the callback(s) to. The value for each entry can be a single
         * callable or an array of callables. Each callable should expect one parameter and return
         * one value. Example:
         *  [
         *      'name' => 'strtolower',
         *      'email' => ['strtolower', 'trim'],
         *      'phone' => [[$someObject, 'methodName']],
         *  ]
         */
        'callbacks' => [],

        // The field delimiter character.
        'delimiter' => ',',

        // The escape character.
        'escape' => '\\',

        // The file to process.
        'file' => 'php://stdin',

        // Does the first row contain column names?
        'header' => true,

        // The field quote charater.
        'quote' => '"',

    ];

    /**
     * Contains the line count.
     *
     * @var int
     */
    protected $line = 0;

    /**
     * Apply callbacks.
     *
     * @param array $row The row to process.
     *
     * @return array The processed row.
     */
    protected function callback($row)
    {
        foreach ($this->getConfig('callbacks') as $column => $callbacks) {
            if (strpos($column, '/') === 0) {
                // Interpret as a regex and apply to all matching columns.
                foreach (array_keys($row) as $name) {
                    if (preg_match($column, $name) === 1) {
                        foreach ((array) $callbacks as $callback) {
                            $row[$name] = call_user_func($callback, $row[$name]);
                        }
                    }
                }
            } else {
                // Apply to one explicitly named column.
                if (!array_key_exists($column, $row)) {
                    throw new \RuntimeException('Unable to apply callback to missing column: ' . $column);
                }
                foreach ((array) $callbacks as $callback) {
                    $row[$column] = call_user_func($callback, $row[$column]);
                }
            }
        }
        return $row;
    }

    /**
     * Required by \IteratorAggregate interface.
     *
     * @return \Generator
     * @throws \RuntimeException On error reading file.
     */
    public function getIterator()
    {
        $csv = fopen($this->getConfig('file'), 'r');
        if ($csv === false) {
            throw new \RuntimeException('Unable to open file: ' . $this->getConfig('file'));
        }
        while (true) {
            $fields = fgetcsv(
                $csv,
                0,
                $this->getConfig('delimiter'),
                $this->getConfig('quote'),
                $this->getConfig('escape')
            );
            if ($fields === false) {
                break;
            }
            ++$this->line;
            if ($this->columns === null && $this->getConfig('header') === true) {
                $this->columns = $fields;
            } else {
                $row = $this->getConfig('header') === true ? $this->map($fields) : $fields;
                yield empty($this->getConfig('callbacks')) === true ? $row : $this->callback($row);
            }
        }
        fclose($csv);
    }

    /**
     * Get the current line number.
     *
     * @return int The current line number.
     */
    public function getLineNumber()
    {
        return $this->line;
    }

    /**
     * Map a line's fields to an associative array key according to the headers.
     *
     * @param array $fields The lields to map.
     *
     * @return array The mapped fields.
     * @throws \RuntimeException
     */
    protected function map($fields)
    {
        $list = [];
        if (count($this->columns) !== count($fields)) {
            throw new \RuntimeException('Column mismatch on line ' . $this->line);
        }
        foreach ($this->columns as $column) {
            $list[$column] = array_shift($fields);
        }
        return $list;
    }

    /**
     * Convert the entire CSV file to one big array.
     *
     * @param string $column If $column is provided, the resulting array will be associative and
     *                       the value in the field named by $column will be used as the array
     *                       key. If $column is not provided, the resulting array will indexed.
     *
     * @return array
     */
    public function toArray($column = null)
    {
        $array = [];
        foreach ($this as $line) {
            if ($column === null) {
                $array[] = $line;
            } else {
                $array[$line[$column]] = $line;
            }
        }
        return $array;
    }

}
