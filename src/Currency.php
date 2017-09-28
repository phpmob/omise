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
final class Currency
{
    const THB = 'thb';
    const JPY = 'jpy';
    const SGD = 'sgd';
    const USD = 'usd';
    const EUR = 'eur';

    private function __construct()
    {
    }

    /**
     * @param string $countryCode
     *
     * @return array
     */
    public static function getSupporteds($countryCode)
    {
        return [
            Country::JP => [
                self::JPY,
            ],
            Country::SG => [
                self::SGD,
            ],
            Country::TH => [
                self::THB,
                self::JPY,
                self::SGD,
                self::USD,
                self::EUR,
            ],
        ][strtolower($countryCode)];
    }

    /**
     * @param string $code
     *
     * @return array
     */
    public static function getMinMaxs($code)
    {
        return [
            self::JPY => [100, 2000000],
            self::SGD => [100, 2000000],
            self::THB => [100, 100000000],
        ][strtolower($code)];
    }

    /**
     * @param string $code
     *
     * @return int
     */
    public static function getDivisionOffset($code)
    {
        return [
            self::JPY => 1,
            self::SGD => 100,
            self::THB => 100,
        ][strtolower($code)];
    }

    /**
     * @param string $code
     *
     * @return int
     */
    public static function getSymblo($code)
    {
        return [
            self::JPY => '¥',
            self::SGD => '$',
            self::THB => '฿',
        ][strtolower($code)];
    }

    /**
     * @param int $amount
     * @param string $code
     *
     * @return int
     */
    public static function convert($amount, $code)
    {
        return $amount * self::getDivisionOffset($code);
    }

    /**
     * @param int $amount
     * @param string $code
     *
     * @return int
     */
    public static function format($amount, $code)
    {
        if ($amount) {
            return $amount / self::getDivisionOffset($code);
        }

        return $amount;
    }
}
