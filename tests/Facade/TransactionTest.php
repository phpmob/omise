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

use PhpMob\Omise\Exception\InvalidRequestArgumentException;
use PhpMob\Omise\Facade\Transaction;
use PhpMob\Omise\Facade\Pagination;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Saranyu <Saranyuphimsahwan@gmail.com>
 */
class TransactionTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_all()
    {
        $this->client->fixture('transaction-list');

        $this->assertInstanceOf(Pagination::class , Transaction::all());
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('transaction');

        $this->assertEquals('trxn_test_5086v66oxpujs6nll93', Transaction::find('trxn_test_5086v66oxpujs6nll93')->id);
    }

    /**
     * @test
     */
    function it_can_not_find_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        Transaction::find('');
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('transaction');

        $transaction = Transaction::find('trxn_test_5086v66oxpujs6nll93');
        $transaction->id = 'trxn_test_5086v66oxpujs6nll93d52111das4w85';

        $transaction->refresh();

        $this->assertEquals('trxn_test_5086v66oxpujs6nll93', $transaction->id);
    }
}
