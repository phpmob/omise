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
use PhpMob\Omise\Domain\Transfer as Domain;
use PhpMob\Omise\Domain\Pagination;

/**
 * @author Prawit <tongmomo001@gmail.com>
 *
 * @see https://www.omise.co/transfer-api
 */
final class Transfer extends Api
{
    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(array $parameters = [])
    {
        return $this->doRequest('GET', '/transfers', $parameters);
    }

    /**
     * @param Domain $transfers
     */
    public function create(Domain $transfers)
    {
        $data = $transfers->getCreateData();

        $transfers->updateStore($this->doRequest('POST', '/transfers', $data)->toArray());
    }

    /**
     * @param Domain $transfers
     */
    public function createWithRecipient(Domain $transfers)
    {
        $data = $transfers->getCreateData();

        self::assertNotEmpty(@$data['recipient'], 'Recipient Id can not be empty.');

        $this->create($transfers);
    }

    /**
     * @param Domain $transfers
     */
    public function update(Domain $transfers)
    {
        self::assertNotEmpty($transfers->id);

        $transfers->updateStore($this->doRequest('PATCH', '/transfers/'.$transfers->id, $transfers->getUpdateData())->toArray());
    }

    /**
     * @param string $id
     *
     * @return Domain
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/transfers/'.$id);
    }

    /**
     * @param Domain $transfers
     */
    public function refresh(Domain $transfers)
    {
        $transfers->updateStore($this->find($transfers->id)->toArray());
    }

    /**
     * @param Domain $transfers
     */
    public function destroy(Domain $transfers)
    {
        self::assertNotEmpty($transfers->id);

        $transfers->updateStore($this->doRequest('DELETE', '/transfers/'.$transfers->id)->toArray());
    }
}
