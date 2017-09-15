<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Api;

use PhpMob\Omise\Api;
use PhpMob\Omise\Domain\Card as Model;
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
     * @return Model
     */
    public function find($customerId, $id)
    {
        self::assertNotEmpty($customerId && $id, 'Customer Id or Id cannot be empty.');

        return $this->doRequest('GET', self::path($customerId, $id));
    }

    /**
     * @param Model $card
     */
    public function refresh(Model $card)
    {
        $card->updateStore($this->find(@$card->customer->id, $card->id)->toArray());
    }

    /**
     * @param Model $card
     */
    public function update(Model $card)
    {
        self::assertNotEmpty(@$card->customer->id && $card->id, 'CustomerId or Id cannot be empty.');

        $card->updateStore(
            $this->doRequest('PATCH', self::path($card->customer->id, $card->id), $card->getUpdateData())->getData()
        );
    }

    /**
     * @param Model $card
     */
    public function destroy(Model $card)
    {
        self::assertNotEmpty(@$card->customer->id && $card->id, 'CustomerId or Id cannot be empty.');

        $card->updateStore(
            $this->doRequest('DELETE', self::path($card->customer->id, $card->id), $card->getUpdateData())->toArray()
        );
    }
}
