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
use PhpMob\Omise\Domain\Customer as Domain;
use PhpMob\Omise\Domain\Pagination;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @see https://www.omise.co/customers-api
 */
final class Customer extends Api
{
    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(array $parameters = [])
    {
        return $this->doRequest('GET', '/customers', $parameters);
    }

    /**
     * @param string $id
     *
     * @return Domain
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/customers/' . $id);
    }

    /**
     * @param Domain $customer
     */
    public function refresh(Domain $customer)
    {
        $customer->updateStore($this->find($customer->id)->toArray());
    }

    /**
     * @param Domain $customer
     */
    public function create(Domain $customer)
    {
        $data = $customer->getCreateData();

        if (empty($data['card'])) {
            unset($data['card']);
        }

        $customer->updateStore($this->doRequest('POST', '/customers', $data)->toArray());
    }

    /**
     * @param Domain $customer
     */
    public function createWithCard(Domain $customer)
    {
        $data = $customer->getCreateData();

        self::assertNotEmpty(@$data['card'], 'Card Token can not be empty.');

        $this->create($customer);
    }

    /**
     * @param Domain $customer
     */
    public function update(Domain $customer)
    {
        self::assertNotEmpty($customer->id);

        $data = $customer->getUpdateData();

        if (empty($data['card'])) {
            unset($data['card']);
        }

        $customer->updateStore($this->doRequest('PATCH', '/customers/' . $customer->id, $data)->toArray());
    }

    /**
     * @param Domain $customer
     */
    public function updateWithCard(Domain $customer)
    {
        $data = $customer->getCreateData();

        self::assertNotEmpty(@$data['card'], 'Card Token can not be empty.');

        $this->update($customer);
    }

    /**
     * @param Domain $customer
     */
    public function destroy(Domain $customer)
    {
        self::assertNotEmpty($customer->id);

        $customer->updateStore($this->doRequest('DELETE', '/customers/' . $customer->id)->toArray());
    }
}
