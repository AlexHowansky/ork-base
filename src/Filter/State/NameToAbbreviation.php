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
 * Convert a state name it its abbreviation.
 */
class NameToAbbreviation implements \Ork\Filter\FilterInterface
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
        'alabama' => 'AL',
        'alaska' => 'AK',
        'arizona' => 'AZ',
        'arkansas' => 'AR',
        'california' => 'CA',
        'colorado' => 'CO',
        'connecticut' => 'CT',
        'delaware' => 'DE',
        'district of columbia' => 'DC',
        'florida' => 'FL',
        'georgia' => 'GA',
        'hawaii' => 'HI',
        'idaho' => 'ID',
        'illinois' => 'IL',
        'indiana' => 'IN',
        'iowa' => 'IA',
        'kansas' => 'KS',
        'kentucky' => 'KY',
        'louisiana' => 'LA',
        'maine' => 'ME',
        'maryland' => 'MD',
        'massachusetts' => 'MA',
        'michigan' => 'MI',
        'minnesota' => 'MN',
        'mississippi' => 'MS',
        'missouri' => 'MO',
        'montana' => 'MT',
        'nebraska' => 'NE',
        'nevada' => 'NV',
        'new hampshire' => 'NH',
        'new jersey' => 'NJ',
        'new mexico' => 'NM',
        'new york' => 'NY',
        'north carolina' => 'NC',
        'north dakota' => 'ND',
        'ohio' => 'OH',
        'oklahoma' => 'OK',
        'oregon' => 'OR',
        'pennsylvania' => 'PA',
        'rhode island' => 'RI',
        'south carolina' => 'SC',
        'south dakota' => 'SD',
        'tennessee' => 'TN',
        'texas' => 'TX',
        'utah' => 'UT',
        'vermont' => 'VT',
        'virginia' => 'VA',
        'washington' => 'WA',
        'west virginia' => 'WV',
        'wisconsin' => 'WI',
        'wyoming' => 'WY',
    ];

    /**
     * The list of allowable territories.
     *
     * @var array
     */
    protected $territories = [
        'american samoa' => 'AS',
        'federated states of micronesia' => 'FM',
        'guam' => 'GU',
        'marshall islands' => 'MH',
        'northern mariana islands' => 'MP',
        'palau' => 'PW',
        'puerto rico' => 'PR',
        'virgin islands' => 'VI',
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
        $normalized = preg_replace('/\s+/', ' ', strtolower(trim($value)));
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
            throw new \UnexpectedValueException('Input value can not be mapped to a state name.');
        }
        return $value;
    }

}
