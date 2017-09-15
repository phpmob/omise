<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\PhpMob\Omise;

use PhpMob\Omise\Api;
use PhpMob\Omise\Client\HttpClientInterface;
use PhpMob\Omise\OmiseApi;
use PhpSpec\ObjectBehavior;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @mixin OmiseApi
 */
class OmiseApiSpec extends ObjectBehavior
{
    function let(HttpClientInterface $httpClient)
    {
        $this->beConstructedWith($httpClient, ['public_key' => 'foo', 'secret_key' => 'bar', 'sandbox' => true]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(OmiseApi::class);
    }

    function it_create_api_service_for_domain()
    {
        $this->create(Api\Token::class)->shouldImplement(Api::class);
    }

    function it_create_api_service_only_supported_type()
    {
        $apiClass = self::class;

        $this->shouldThrow(
            new \LogicException("The api class ($apiClass) should have sub-type of ".Api::class)
        )->duringCreate($apiClass);
    }
}
