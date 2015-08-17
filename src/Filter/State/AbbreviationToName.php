<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork\Filter\State;

/**
 * Convert a state abbreviation to its full name.
 */
class AbbreviationToName implements \Ork\Filter\FilterInterface
{

    use \Ork\ConfigurableTrait;

    /**
     * Configurable trait settings.
     *
     * @var array
     */
    protected $config = [

        // Throw an exception on invalid input. Otherwise, return it untouched.
        'abortOnInvalidInput' => true,

        // Include territories that aren't states but have US mailing addresses.
        'includeTerritories' => false,

    ];

    /**
     * The list of allowable states.
     *
     * @var array
     */
    protected $states = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
    ];

    /**
     * The list of allowable territories.
     *
     * @var array
     */
    protected $territories = [
        'AS' => 'American Samoa',
        'FM' => 'Federated States of Micronesia',
        'GU' => 'Guam',
        'MH' => 'Marshall Islands',
        'MP' => 'Northern Mariana Islands',
        'PW' => 'Palau',
        'PR' => 'Puerto Rico',
        'VI' => 'Virgin Islands',
    ];

    /**
     * Filter a value.
     *
     * @param mixed $value The value to filter.
     *
     * @return mixed The filtered value.
     */
    public function filter($value)
    {
        $normalized = strtoupper(trim($value));
        if (array_key_exists($normalized, $this->states) === true) {
            return $this->states[$normalized];
        }
        if (
            $this->getConfig('includeTerritories') === true &&
            array_key_exists($normalized, $this->territories) === true
        ) {
            return $this->territories[$normalized];
        }
        if ($this->getConfig('abortOnInvalidInput') === true) {
            throw new \UnexpectedValueException('Input value can not be mapped to a state abbreviation.');
        }
        return $value;
    }

}
