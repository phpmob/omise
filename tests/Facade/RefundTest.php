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

use PhpMob\Omise\Facade\Charge;
use PhpMob\Omise\Facade\Pagination;
use PhpMob\Omise\Facade\Refund;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class RefundTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_item()
    {
        $this->client->fixture('refund-list');

        $this->assertInstanceOf(Pagination::class, Refund::all());
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('refund');

        $this->assertEquals('rfnd_test_5086xm1i7ddm3apeaev',
            Refund::find('chrg_test_5086xlsx4lghk9bpb75', 'rfnd_test_5086xm1i7ddm3apeaev')->id);
    }
}
