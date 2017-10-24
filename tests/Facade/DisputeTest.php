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
use PhpMob\Omise\Facade\Dispute;
use PhpMob\Omise\Facade\Pagination;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Saranyu <Saranyuphimsahwan@gmail.com>
 */
class DisputeTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_all()
    {
        $this->client->fixture('dispute-list');

        $this->assertInstanceOf(Pagination::class , Dispute::all());
    }

    /**
     * @test
     */
    function it_can_fetch_open()
    {
        $this->client->fixture('dispute-list');

        $this->assertInstanceOf(Pagination::class , Dispute::opens());
    }

    /**
     * @test
     */
    function it_can_fetch_pending()
    {
        $this->client->fixture('dispute-list');

        $this->assertInstanceOf(Pagination::class , Dispute::pendings());
    }

    /**
     * @test
     */
    function it_can_fetch_closed()
    {
        $this->client->fixture('dispute-list');

        $this->assertInstanceOf(Pagination::class , Dispute::closeds());
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('dispute');

        $this->assertEquals('dspt_test_4zgf15h89w8t775kcm8', Dispute::find('dspt_test_4zgf15h89w8t775kcm8')->id);
    }

    /**
     * @test
     */
    function it_can_not_find_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        Dispute::find('');
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('dispute');

        $dispute = Dispute::find('dspt_test_4zgf15h89w8t775kcm8');
        $dispute->id = 'dspt_test_4zgf15wa23f89w8t775kcm8';

        $dispute->refresh();

        $this->assertEquals('dspt_test_4zgf15h89w8t775kcm8', $dispute->id);
    }

    /**
     * @test
     */
    function it_can_update_item()
    {
        $this->client->fixture('dispute');

        $dispute = Dispute::find('dspt_test_4zgf15h89w8t775kcm8');
        $dispute->message = 'Proofs and other information regarding the disputed charge ...';

        $dispute->update();

        $this->assertNotEmpty($dispute->id);
    }
}
