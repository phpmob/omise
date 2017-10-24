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
use PhpMob\Omise\Domain\Recipient as Domain;
use PhpMob\Omise\Domain\Pagination;

/**
 * @author Prawit <tongmomo001@gmail.com>
 *
 * @see https://www.omise.co/recipients-api
 */
final class Recipient extends Api
{
    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(array $parameters = [])
    {
        return $this->doRequest('GET', '/recipients', $parameters);
    }

    /**
     * @param Domain $recipient
     */
    public function create(Domain $recipient)
    {
        $recipient->updateStore($this->doRequest('POST', '/recipients', $recipient->getCreateData())->toArray());
    }

    /**
     * @param Domain $recipient
     */
    public function update(Domain $recipient)
    {
        self::assertNotEmpty($recipient->id);

        $recipient->updateStore($this->doRequest('PATCH', '/recipients/'.$recipient->id, $recipient->getUpdateData())->toArray());
    }

    /**
     * @param string $id
     *
     * @return Domain
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/recipients/'.$id);
    }

    /**
     * @param Domain $recipient
     */
    public function refresh(Domain $recipient)
    {
        $recipient->updateStore($this->find($recipient->id)->toArray());
    }

    /**
     * @param Domain $recipient
     */
    public function destroy(Domain $recipient)
    {
        self::assertNotEmpty($recipient->id);

        $recipient->updateStore($this->doRequest('DELETE', '/recipients/'.$recipient->id)->toArray());
    }
}
