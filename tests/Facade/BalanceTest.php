<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\PhpMob\Omise\Facade;

use PhpMob\Omise\Facade\Balance;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class BalanceTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_item()
    {
        $this->client->fixture('balance');

        $this->assertEquals('thb', Balance::fetch()->currency);
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('account');

        $balance = new Balance();

        $balance->currency = 'jpy';

        $balance->refresh();

        $this->assertEquals('thb', $balance->currency);
    }
}
