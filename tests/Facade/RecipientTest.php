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

use PhpMob\Omise\Facade\Recipient;
use PhpMob\Omise\Facade\Pagination;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Prawit <tongmomo01@gmail.com>
 */
class RecipientTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_all()
    {
        $this->client->fixture('recipient-list');

        $this->assertInstanceOf(Pagination::class, Recipient::all());
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('recipient');

        $this->assertEquals('recp_test_5086xmr74vxs0ajpo78', Recipient::find('recp_test_5086xmr74vxs0ajpo78')->id);
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('recipient');

        $recipient = Recipient::find('recp_test_5086xmr74vxs0ajpo78');
        $recipient->name = 'recp_test_5086xmr74vxs0aj32po78d341';

        $recipient->refresh();

        $this->assertEquals('recp_test_5086xmr74vxs0ajpo78', $recipient->id);
    }

    /**
     * @test
     */
    function it_can_create_item()
    {
        $this->client->fixture('recipient');

        $recipient = new Recipient();

        $recipient->name = 'Omise Tester';
        $recipient->description = 'Tester account';
        $recipient->email = 'tester@omise.co';
        $recipient->type = 'individual';
        $recipient->taxId = '';
        $recipient->bankAccount = array(
            'brand' => 'bbl',
            'number' => '1234567890',
            'name' => 'Tester Account'
        );

        $recipient->create();

        $this->assertNotEmpty($recipient->id);
    }

    /**
     * @test
     */
    function it_can_update_item()
    {
        $this->client->fixture('recipient');

        $recipient = Recipient::find('recp_test_5086xmr74vxs0ajpo78');
        $recipient->name = 'Omise Tester';
        $recipient->email = 'tester@omise.co';
        $recipient->description = 'Another description';

        $recipient->update();

        $this->assertNotEmpty($recipient->id);
    }

    /**
     * @test
     */
    function it_can_destroy_item()
    {
        $this->client->fixture('recipient-deleted');

        $recipient = Recipient::find('recp_test_5086xmr74vxs0ajpo78');

        $recipient->destroy();
    }
}
