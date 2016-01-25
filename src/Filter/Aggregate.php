<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015-2016 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Filter;

/**
 * A meta-filter object that applies a list of other filters.
 */
class Aggregate implements FilterInterface, \IteratorAggregate
{

    /**
     * The list of filters to apply.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Constructor.
     *
     * @param array $filters The filters to apply.
     */
    public function __construct(array $filters = [])
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     * Add a filter to the list.
     *
     * @param \Ork\Filter\FilterInterface $filter The filter to add.
     *
     * @return \Ork\Filter\Aggregate Allow method chaining.
     */
    public function addFilter(\Ork\Filter\FilterInterface $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * Apply all the filters to the value.
     *
     * @param mixed $value The filter to value.
     *
     * @return mixed The filtered value.
     */
    public function filter($value)
    {
        foreach ($this->filters as $filter) {
            $value = $filter->filter($value);
        }
        return $value;
    }

    /**
     * Iterate over the defined filters.
     *
     * @return \Generator
     */
    public function getIterator()
    {
        foreach ($this->filters as $filter) {
            yield $filter;
        }
    }

}
