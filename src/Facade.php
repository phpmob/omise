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

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
abstract class Facade
{
    /**
     * @var Api[]
     */
    protected static $api = [];

    /**
     * @var Model
     */
    protected $domain;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $class = str_replace('Facade', 'Domain', get_called_class());

        $this->domain = new $class($data);
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function make(array $data = [])
    {
        return new static($data);
    }

    /**
     * @param Api $api
     */
    public static function setApi(Api $api)
    {
        self::$api[get_called_class()] = $api;
    }

    /**
     * @return Api
     */
    private static function getApiForClass()
    {
        return self::$api[get_called_class()];
    }

    /**
     * @param $method
     */
    private static function checkApiMethodExists($method)
    {
        if (!method_exists(self::getApiForClass(), $method)) {
            throw new \InvalidArgumentException(
                sprintf('Not found method named `%s` for `%s` api.', $method, get_called_class())
            );
        }
    }

    /**
     * @param string $method
     * @param array $args
     *
     * @return mixed|self
     */
    public static function __callStatic($method, $args)
    {
        self::checkApiMethodExists($method);

        return self::getApiForClass()->$method(...$args);
    }

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (method_exists($this->domain, $method)) {
            return $this->domain->$method(...$args);
        }

        self::checkApiMethodExists($method);

        return self::getApiForClass()->$method($this->domain, ...$args);
    }

    public function __get($name)
    {
        $result = $this->domain->$name;

        /**
         * No need due to `FacadeHydration` implementation.
         * if ($result instanceof Model) {
         *   $class = str_replace('Domain', 'Facade', get_class($result));
         *
         *   return new $class($result->toArray());
         * }
         */

        return $result;
    }

    public function __set($name, $value)
    {
        $this->domain->$name = $value;
    }
}
