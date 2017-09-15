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
use PhpMob\Omise\Domain\Charge as Domain;
use PhpMob\Omise\Domain\Pagination;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @see https://www.omise.co/charges-api
 */
final class Charge extends Api
{
    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(array $parameters = [])
    {
        return $this->doRequest('GET', '/charges', $parameters);
    }

    /**
     * @param string $id
     *
     * @return Domain
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/charges/'.$id);
    }

    /**
     * @param Domain $charge
     */
    public function refresh(Domain $charge)
    {
        $charge->updateStore($this->find($charge->id)->toArray());
    }

    /**
     * @param Domain $charge
     */
    public function create(Domain $charge)
    {
        $charge->updateStore($this->doRequest('POST', '/charges', $charge->getCreateData())->toArray());
    }

    /**
     * @param Domain $charge
     */
    public function createUsingToken(Domain $charge)
    {
        self::assertNotEmpty(@$charge->card->id, 'Card token can not be empty.');

        $this->create($charge);
    }

    /**
     * @param Domain $charge
     */
    public function createUsingCustomer(Domain $charge)
    {
        self::assertNotEmpty(@$charge->customer->id, 'Customer id can not be empty.');

        $this->create($charge);
    }

    /**
     * @param Domain $charge
     */
    public function createUsingCustomerAndCard(Domain $charge)
    {
        self::assertNotEmpty(@$charge->customer->id && @$charge->card->id, 'Require `customer` and `card`.');

        $this->create($charge);
    }

    /**
     * @param Domain $charge
     */
    public function update(Domain $charge)
    {
        self::assertNotEmpty($charge->id);

        $charge->updateStore($this->doRequest('PATCH', '/charges/'.$charge->id, $charge->getUpdateData())->toArray());
    }

    /**
     * @param Domain $charge
     */
    public function capture(Domain $charge)
    {
        self::assertNotEmpty($charge->id);

        $charge->updateStore($this->doRequest('POST', '/charges/'.$charge->id.'/capture')->toArray());
    }

    /**
     * @param Domain $charge
     */
    public function reverse(Domain $charge)
    {
        self::assertNotEmpty($charge->id);

        $charge->updateStore($this->doRequest('POST', '/charges/'.$charge->id.'/reverse')->toArray());
    }
}
