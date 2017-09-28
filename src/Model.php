<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\Omise;

use Doctrine\Common\Inflector\Inflector;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
abstract class Model
{
    /**
     * @var string
     */
    protected $idAttribute = 'id';

    /**
     * @var array
     */
    protected $store = [];

    /**
     * @param array $store
     */
    public function __construct(array $store = [])
    {
        $this->store = $store;
    }

    /**
     * @param array $store
     *
     * @return static
     */
    public static function make(array $store = [])
    {
        return new static($store);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->store;
    }

    /**
     * @param array $data
     */
    public function updateStore(array $data)
    {
        $this->store = $data;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $idAttribute = $this->idAttribute;

        return (string) $this->$idAttribute;
    }

    public function __get($name)
    {
        $name = Inflector::tableize($property = $name);

        if (!array_key_exists($name, $this->store)) {
            return property_exists(get_called_class(), $property) ? $this->$property : null;
        }

        return $this->store[$name];
    }

    public function __set($name, $value)
    {
        $this->store[Inflector::tableize($name)] = $value;
    }

    /*public function convertDateTime($string)
    {
        // TODO:
    }*/
}
