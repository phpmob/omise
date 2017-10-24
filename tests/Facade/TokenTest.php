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
use PhpMob\Omise\Facade\Card;
use PhpMob\Omise\Facade\Token;
use tests\PhpMob\Omise\FacadeTestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TokenTest extends FacadeTestCase
{
    /**
     * @test
     */
    function it_can_create_item()
    {
        $this->client->fixture('token');

        $token = new Token();

        $token->card = new Card();
        $token->card->name = 'Somchai Prasert';
        $token->card->number = '4242424242424242';
        $token->card->city = 'Bangkok';
        $token->card->postalCode = '10320';
        $token->card->expirationMonth = 10;
        $token->card->expirationYear = 2018;
        $token->card->securityCode = 123;

        $token->create();

        $this->assertNotEmpty($token->id);
    }

    /**
     * @test
     */
    function it_can_find_item()
    {
        $this->client->fixture('token');

        $this->assertEquals($this->tokenId, Token::find($this->tokenId)->id);
    }

    /**
     * @test
     */
    function it_can_not_find_item_without_id()
    {
        $this->expectException(InvalidRequestArgumentException::class);
        $this->expectExceptionMessage('Id can not be empty.');

        Token::find('');
    }

    /**
     * @test
     */
    function it_can_refresh_item()
    {
        $this->client->fixture('token');

        $token = Token::find($this->tokenId);
        $token->card = new Card();

        $token->refresh();

        $this->assertEquals('Bangkok', $token->card->city);
    }
}
