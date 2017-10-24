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
use PhpMob\Omise\Facade\Recipient;
use PhpMob\Omise\Facade\Transfer;
use PhpMob\Omise\Facade\Pagination;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Prawit <tongmomo01@gmail.com>
 */
class TransferTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_all()
    {
        $this->client->fixture('transfer-list');

        $this->assertInstanceOf(Pagination::class, Transfer::all());
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('transfer');

        $this->assertEquals('trsf_test_5086uxn23hfaxv8nl0f', Transfer::find('trsf_test_5086uxn23hfaxv8nl0f')->id);
    }

    /**
     * @test
     */
    function it_can_not_find_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        Transfer::find('');
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('transfer');

        $transfer = Transfer::find('trsf_test_5086uxn23hfaxv8nl0f');
        $transfer->id = 'testId';

        $transfer->refresh();

        $this->assertEquals("trsf_test_5086uxn23hfaxv8nl0f", $transfer->id);
    }

    /**
     * @test
     */
    function it_can_create_item()
    {
        $this->client->fixture('transfer');

        $transfer = new Transfer();

        $transfer->amount = 100000;

        $transfer->create();

        $this->assertNotEmpty($transfer->id);
    }

    /**
     * @test
     */
    function it_can_create_with_recipient_item()
    {
        $this->client->fixture('transfer');

        $transfer = new Transfer();

        $transfer->amount = 100000;
        $transfer->recipient = 'recp_test_4z6p7e0m4k40txecj5o';

        $transfer->createWithRecipient();

        $this->assertNotEmpty($transfer->id);
    }
}
