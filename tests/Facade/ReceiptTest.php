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
use PhpMob\Omise\Facade\Receipt;
use PhpMob\Omise\Facade\Pagination;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Prawit <tongmomo001@gmail.com>
 */
class ReceiptTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_all()
    {
        $this->client->fixture('receipt-list');

        $this->assertInstanceOf(Pagination::class , Receipt::all());
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('receipt');

        $this->assertEquals('rcpt_test_4zgf15h89w8t775kcm8', Receipt::find('rcpt_test_4zgf15h89w8t775kcm8')->id);
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('receipt');

        $receipt = Receipt::find('rcpt_test_4zgf15h89w8t775kcm8');
        $receipt->id = 'rcpt_test_4zgf15h89w8t775kcm8121';

        $receipt->refresh();

        $this->assertEquals('rcpt_test_4zgf15h89w8t775kcm8', $receipt->id);
    }

    /**
     * @test
     */
    function it_can_not_find_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        Receipt::find('');
    }
}
