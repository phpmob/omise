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

use PhpMob\Omise\Facade\Account;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class AccountTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_item()
    {
        $this->client->fixture('account');

        $this->assertEquals('acct_4x7d2wtqnj2f4klrfsc', Account::fetch()->id);
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('account');

        $account = new Account();
        $account->id = 'foo';

        $account->refresh();

        $this->assertEquals('acct_4x7d2wtqnj2f4klrfsc', $account->id);
    }
}
