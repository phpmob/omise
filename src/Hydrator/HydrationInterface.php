<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Hydrator;

use PhpMob\Omise\Exception\InvalidResponseException;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface HydrationInterface
{
    /**
     * @param string $rawData
     *
     * @return mixed
     * @throws InvalidResponseException
     */
    public function hydrate($rawData);

    /**
     * @param $objectName
     *
     * @return string
     */
    public static function getDomainClass($objectName);

    /**
     * @return string
     */
    public static function getDomainAssertionClass();
}
