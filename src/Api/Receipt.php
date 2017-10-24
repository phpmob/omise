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
use PhpMob\Omise\Domain\Receipt as Domain;
use PhpMob\Omise\Domain\Pagination;

/**
 * @author Prawit <tongmomo001@gmail.com>
 *
 * @see https://www.omise.co/receipt-api
 */
final class Receipt extends Api
{
    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(array $parameters = [])
    {
        return $this->doRequest('GET', '/receipts', $parameters);
    }

    /**
     * @param string $id
     *
     * @return Domain
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/receipts/'.$id);
    }

    /**
     * @param Domain $receipt
     */
    public function refresh(Domain $receipt )
    {
        $receipt->updateStore($this->find($receipt->id)->toArray());
    }
}
