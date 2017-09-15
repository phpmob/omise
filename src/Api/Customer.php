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
use PhpMob\Omise\Domain\Customer as Model;
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
     * @return Model
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/customers/'.$id);
    }

    /**
     * @param Model $customer
     */
    public function refresh(Model $customer)
    {
        $customer->updateStore($this->find($customer->id)->toArray());
    }

    /**
     * @param Model $customer
     */
    public function create(Model $customer)
    {
        $data = $customer->getCreateData();

        if (empty($data['card'])) {
            unset($data['card']);
        }

        $customer->updateStore($this->doRequest('POST', '/customers', $data)->toArray());
    }

    /**
     * @param Model $customer
     */
    public function createWithCard(Model $customer)
    {
        $data = $customer->getCreateData();

        self::assertNotEmpty(@$data['card'], 'Card Id can not be empty.');

        $this->create($customer);
    }

    /**
     * @param Model $customer
     */
    public function update(Model $customer)
    {
        self::assertNotEmpty($customer->id);

        $data = $customer->getUpdateData();

        if (empty($data['card'])) {
            unset($data['card']);
        }

        $customer->updateStore($this->doRequest('PATCH', '/customers/'.$customer->id, $data)->toArray());
    }

    /**
     * @param Model $customer
     */
    public function updateWithCard(Model $customer)
    {
        $data = $customer->getCreateData();

        self::assertNotEmpty(@$data['card'], 'Card Id can not be empty.');

        $this->update($customer);
    }

    /**
     * @param Model $customer
     */
    public function destroy(Model $customer)
    {
        self::assertNotEmpty($customer->id);

        $customer->updateStore($this->doRequest('DELETE', '/customers/'.$customer->id)->toArray());
    }
}
