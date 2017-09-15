<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Mock;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Fixture
{
    public static function get($fileName)
    {
        return file_get_contents(__DIR__."/fixtures/$fileName.json");
    }

    public static function secretHeaders()
    {
        return ['Authorization' => 'Basic '.base64_encode('secret_key:')];
    }

    public static function secretJsonHeaders()
    {
        return [
            "Content-Type" => "application/json; charset=utf-8",
            'Authorization' => 'Basic '.base64_encode('secret_key:'),
        ];
    }

    public static function publicHeaders()
    {
        return ['Authorization' => 'Basic '.base64_encode('public_key:')];
    }

    public static function publicJsonHeaders()
    {
        return [
            "Content-Type" => "application/json; charset=utf-8",
            'Authorization' => 'Basic '.base64_encode('public_key:'),
        ];
    }
}
