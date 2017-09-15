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

use PhpMob\Omise\Currency;
use PhpMob\Omise\Exception\InvalidRequestArgumentException;
use PhpMob\Omise\Facade\Charge;
use PhpMob\Omise\Facade\Pagination;
use PhpMob\Omise\Mock\FacadeTestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class ChargeTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_all()
    {
        $this->client->fixture('charge-list');

        $this->assertInstanceOf(Pagination::class, Charge::all());
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('charge');

        $this->assertEquals($this->chargeId, Charge::find($this->chargeId)->id);
    }

    /**
     * @test
     */
    function it_can_not_find_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        Charge::find('');
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('charge');

        $charge = Charge::find($this->chargeId);
        $charge->description = 'foo';

        $this->assertEquals('foo', $charge->description);

        $charge->refresh();

        $this->assertEquals(null, $charge->description);
    }

    /**
     * @test
     */
    function it_can_create_item()
    {
        $this->client->fixture('charge');

        $charge = new Charge();
        $charge->description = 'foo';
        $charge->amount = 10000;
        $charge->currency = Currency::THB;
        $charge->card = $this->tokenId;

        $charge->create();

        $this->assertNotEmpty($charge->id);
    }
}
