<?php

/**
 * Ork
 *
 * @package   Ork_Base
 * @copyright 2015 Alex Howansky (https://github.com/AlexHowansky)
 * @license   https://github.com/AlexHowansky/ork-base/blob/master/LICENSE MIT License
 * @link      https://github.com/AlexHowansky/ork-base
 */

namespace Ork;

/**
 * Configurable trait.
 *
 * Classes using this trait must define a protected array named $config, which
 * contains (as keys) the names of the configuration values and optionally (as
 * values) a default value. For example:
 *
 * <code>
 * protected $config = [
 *     'foo' => null,
 *     'bar' => 1,
 * ];
 * </code>
 */
trait ConfigurableTrait
{

    /**
     * Constructor.
     *
     * @param array|\Traversable|string $config The configuration names/values to set, or a
     *                                          file name that containins them in JSON format.
     *
     * @throws \LogicException If config attribute has not been defined.
     */
    public function __construct($config = null)
    {
        if (property_exists($this, 'config') === false || is_array($this->config) === false) {
            throw new \LogicException(
                'Class definition for ' . get_class($this) . ' must include array attribute named config.'
            );
        }
        if ($config !== null) {
            if (is_string($config) === true) {
                $this->loadConfig($config);
            } else {
                $this->setConfigs($config);
            }
        }
    }

    /**
     * Get the value of a configuration attribute.
     *
     * @param string $name The name of the configuration attribute to get the value for.
     *
     * @return mixed The value of the named configuration attribute.
     */
    public function getConfig($name = null)
    {
        return $this->validateConfig($name)->config[$name];
    }

    /**
     * Get all configuration attributes.
     *
     * @return array All configuration attributes.
     */
    public function getConfigs()
    {
        return $this->config;
    }

    /**
     * Set configuration from a JSON file.
     *
     * @param string $file The file containing the configuration.
     *
     * @return mixed Allow method chaining.
     * @throws \RuntimeException On error.
     */
    public function loadConfig($file)
    {
        if (file_exists($file) === false) {
            throw new \RuntimeException('No such config file: ' . $file);
        }
        $data = json_decode(file_get_contents($file), true);
        if ($data === null) {
            throw new \RuntimeException('Invalid config file: ' . $file);
        }
        return $this->setConfigs($data);
    }

    /**
     * Set a configuration attribute.
     *
     * @param string $name  The name of the configuration attribute to set.
     * @param mixed  $value The value to set the configuration attribute to.
     *
     * @return mixed Allow method chaining.
     */
    public function setConfig($name, $value)
    {
        $this->validateConfig($name)->config[$name] = $value;
        return $this;
    }

    /**
     * Set multiple configuration attributes.
     *
     * @param array|\Traversable $config The configuration attributes to set.
     *
     * @return mixed Allow method chaining.
     * @throws \InvalidArgumentException On error.
     */
    public function setConfigs($config)
    {
        if (is_array($config) === false && $config instanceof \Traversable === false) {
            throw new \InvalidArgumentException(
                'Expected an array or Traversable; received: ' .
                (is_object($config) === true ? get_class($config) : gettype($config))
            );
        }
        foreach ($config as $name => $value) {
            $this->setConfig($name, $value);
        }
        return $this;
    }

    /**
     * Validate that the named configuration attribute exists.
     *
     * @param string $name The configuration attribute to validate.
     *
     * @return mixed Allow method chaining.
     * @throws \UnexpectedValueException If the named configuration attribute does not exist.
     */
    protected function validateConfig($name)
    {
        if (array_key_exists($name, $this->config) === false) {
            throw new \UnexpectedValueException('No such configuration attribute: ' . $name);
        }
        return $this;
    }

}
