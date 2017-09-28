<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\Omise\Api;

use PhpMob\Omise\Api;
use PhpMob\Omise\Domain\Card as Domain;
use PhpMob\Omise\Domain\Customer;
use PhpMob\Omise\Domain\Pagination;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @see https://www.omise.co/cards-api
 */
final class Card extends Api
{
    /**
     * @param string $customerId
     * @param string $cardId
     *
     * @return string
     */
    private static function path($customerId, $cardId)
    {
        return "/customers/$customerId/cards/$cardId";
    }

    /**
     * @param Customer $customer
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(Customer $customer, array $parameters = [])
    {
        self::assertNotEmpty($customer->id, 'Customer Id cannot be empty.');

        return $this->doRequest('GET', "/customers/$customer->id/cards", $parameters);
    }

    /**
     * @param string $customerId
     * @param string $id
     *
     * @return Domain
     */
    public function find($customerId, $id)
    {
        self::assertNotEmpty($customerId && $id, 'Customer Id or Id cannot be empty.');

        return $this->doRequest('GET', self::path($customerId, $id));
    }

    /**
     * @param Domain $card
     */
    public function refresh(Domain $card)
    {
        $card->updateStore($this->find((string) ($card->customer), $card->id)->toArray());
    }

    /**
     * @param Domain $card
     */
    public function update(Domain $card)
    {
        self::assertNotEmpty((string) ($card->customer) && $card->id, 'CustomerId or Id cannot be empty.');

        $card->updateStore(
            $this->doRequest('PATCH', self::path((string) ($card->customer), $card->id), $card->getUpdateData())->getData()
        );
    }

    /**
     * @param Domain $card
     */
    public function destroy(Domain $card)
    {
        self::assertNotEmpty((string) ($card->customer) && $card->id, 'CustomerId or Id cannot be empty.');

        $card->updateStore(
            $this->doRequest('DELETE', self::path((string) ($card->customer), $card->id), $card->getUpdateData())->toArray()
        );
    }
}
