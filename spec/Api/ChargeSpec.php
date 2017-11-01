<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\PhpMob\Omise\Api;

use PhpMob\Omise\Api\Charge as ChargeApi;
use PhpMob\Omise\Client\HttpClientInterface;
use PhpMob\Omise\Domain\Card;
use PhpMob\Omise\Exception\InvalidRequestArgumentException;
use PhpMob\Omise\Exception\InvalidResponseException;
use PhpMob\Omise\Domain\Charge;
use PhpMob\Omise\OmiseApi;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use tests\PhpMob\Omise\Fixture;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @mixin ChargeApi
 */
final class ChargeSpec extends ObjectBehavior
{
    const ENDPOINT = OmiseApi::OMISE_ENDPOINT.'charges';

    function let(HttpClientInterface $httpClient)
    {
        $this->beConstructedWith(
            $httpClient,
            [
                'sandbox' => true,
                'sensitive' => false,
                'secret_key' => 'secret_key',
                'public_key' => 'public_key',
            ]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChargeApi::class);
    }

    function it_can_retrive_charge_list(
        HttpClientInterface $httpClient,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $httpClient->send('GET', self::ENDPOINT, [], Fixture::secretHeaders())->willReturn($response);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn($data = Fixture::get('charge-list'));

        $list = $this->all();
        $list->object->shouldReturn('list');
        $list->limit->shouldReturn(20);
        $list->data[0]->object->shouldReturn('charge');
        $list->data[0]->failureCode->shouldReturn(null);
    }

    function it_can_fetch_single_item(
        HttpClientInterface $httpClient,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $id = 'foo';
        $httpClient->send('GET', self::ENDPOINT.'/'.$id, [], Fixture::secretHeaders())->willReturn($response);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn(Fixture::get('charge'));

        $this->find($id)->id->shouldReturn('chrg_test_5086xlsx4lghk9bpb75');
    }

    function it_can_not_fetch_item_witout_id()
    {
        $this->shouldThrow(new InvalidRequestArgumentException("Id can not be empty."))->duringFind('');
    }

    function it_can_refresh_item(
        HttpClientInterface $httpClient,
        ResponseInterface $response,
        StreamInterface $stream,
        Charge $charge
    ) {
        $id = 'chrg_test_5086xlsx4lghk9bpb75';
        $charge->id = $id;

        $httpClient->send('GET', self::ENDPOINT.'/'.$id, [], Fixture::secretHeaders())->willReturn($response);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn(Fixture::get('charge'));

        $charge->updateStore(Argument::any())->shouldBeCalled();

        $this->refresh($charge);
    }

    function it_can_not_refresh_item_witout_id(Charge $charge)
    {
        $charge->id = null;
        $this->shouldThrow(new InvalidRequestArgumentException("Id can not be empty."))->duringRefresh($charge);
    }

    function it_can_create_item(
        HttpClientInterface $httpClient,
        ResponseInterface $response,
        StreamInterface $stream,
        Charge $charge
    ) {
        $httpClient->send('POST', self::ENDPOINT, ["livemode" => false], Fixture::secretJsonHeaders())->willReturn(
            $response
        );
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn(Fixture::get('charge'));

        $charge->getCreateData()->shouldBeCalled()->willReturn([]);
        $charge->updateStore(Argument::any())->shouldBeCalled();

        $this->create($charge);
    }

    function it_can_not_create_item_when_input_not_valid_eg_currency_is_empty(
        HttpClientInterface $httpClient,
        ResponseInterface $response,
        StreamInterface $stream,
        Charge $charge
    ) {
        $errorData = Fixture::get('error-invalid-charge');

        $charge->getCreateData()->shouldBeCalled()->willReturn([]);

        $httpClient->send('POST', self::ENDPOINT, ["livemode" => false], Fixture::secretJsonHeaders())
            ->willReturn($response);

        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn($errorData);

        $this->shouldThrow(InvalidResponseException::class)->duringCreate($charge);
    }

    function it_can_create_item_using_card_token(
        HttpClientInterface $httpClient,
        ResponseInterface $response,
        StreamInterface $stream,
        Charge $charge
    ) {
        $charge->cardToken = 'foo';

        $httpClient->send('POST', self::ENDPOINT, ["livemode" => false], Fixture::secretJsonHeaders())->willReturn(
            $response
        );
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn($data = Fixture::get('charge'));

        $charge->getCreateUsingTokenData()->shouldBeCalled()->willReturn([]);
        $charge->updateStore(Argument::any())->shouldBeCalled();

        $this->createUsingToken($charge);
    }

    function it_should_throw_exception_when_create_item_using_empty_card_token(Charge $charge)
    {
        $charge->card = null;

        $this->shouldThrow(new InvalidRequestArgumentException("Card token can not be empty."))
            ->duringCreateUsingToken($charge);
    }
}
