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
use PhpMob\Omise\Facade\Customer;
use PhpMob\Omise\Facade\Pagination;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class CustomerTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_fetch_all()
    {
        $this->client->fixture('customer-list');

        $this->assertInstanceOf(Pagination::class, Customer::all());
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('customer');

        $this->assertEquals($this->customerId, Customer::find($this->customerId)->id);
    }

    /**
     * @test
     */
    function it_can_not_find_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        Customer::find('');
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('customer');

        $customer = Customer::find($this->customerId);
        $customer->object = 'foo';

        $this->assertEquals('foo', $customer->object);

        $customer->refresh();

        $this->assertEquals('customer', $customer->object);
    }

    /**
     * @test
     */
    function it_can_create_item()
    {
        $data = [
            'object' => 'customer',
            'email' => 'email@test.com',
            'description' => 'description',
        ];

        $this->client->content(json_encode($data));

        $customer = Customer::make($data);

        $customer->create();

        $this->assertEquals('email@test.com', $customer->email);
    }

    /**
     * @test
     */
    function it_can_create_item_with_card()
    {
        $data = [
            'object' => 'customer',
            'email' => 'email@test.com',
            'description' => 'description',
            'card_token' => 'foo',
        ];

        $this->client->content(json_encode($data));

        $customer = Customer::make($data);

        $customer->createWithCard();

        $this->assertEquals('email@test.com', $customer->email);
    }

    /**
     * @test
     */
    function it_can_not_create_item_with_card_when_have_no_card_token()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Card Token can not be empty.');

        $customer = Customer::make([]);
        $customer->cardToken = '';

        $customer->createWithCard();

        $this->assertEquals('email@test.com', $customer->email);
    }

    /**
     * @test
     */
    function it_can_update_item()
    {
        $data = [
            'object' => 'customer',
            'id' => 'test',
            'email' => 'new@test.com',
            'description' => 'description',
        ];

        $this->client->content(json_encode($data));

        $customer = Customer::make($data);

        $customer->update();

        $this->assertEquals('new@test.com', $customer->email);
    }

    /**
     * @test
     */
    function it_can_update_item_with_card()
    {
        $data = [
            'object' => 'customer',
            'id' => 'test',
            'email' => 'email@test.com',
            'description' => 'description',
            'card_token' => 'bar',
        ];

        $this->client->content(json_encode($data));

        $customer = Customer::make($data);

        $customer->updateWithCard();

        $this->assertEquals('bar', $customer->cardToken);
    }

    /**
     * @test
     */
    function it_can_not_update_item_with_card_when_have_no_card_token()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Card Token can not be empty.');

        $customer = Customer::make([]);
        $customer->cardToken = '';

        $customer->updateWithCard();
    }

    /**
     * @test
     */
    function it_can_not_update_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        $customer = Customer::make([]);

        $customer->update();
    }

    /**
     * @test
     */
    function it_can_not_destroy_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        $customer = Customer::make();

        $customer->destroy();
    }

    /**
     * @test
     */
    function it_can_destroy_item()
    {
        $this->client->fixture('customer-deleted');

        $customer = Customer::make(['id' => 'foo']);

        $customer->destroy();

        $this->assertTrue($customer->deleted);
    }
}
