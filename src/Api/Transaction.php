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
use PhpMob\Omise\Domain\Pagination;
use PhpMob\Omise\Domain\Transaction as Domain;

/**
 * @author Saranyu <saranyuphimsahwan@gmail.com>
 *
 * @see https://www.omise.co/transactions-api
 */
final class Transaction extends Api
{
    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(array $parameters = [])
    {
        return $this->doRequest('GET', '/transactions', $parameters);
    }

    /**
     * @param string $id
     *
     * @return Domain
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/transactions/' . $id);
    }

    /**
     * @param Domain $transaction
     */
    public function refresh(Domain $transaction)
    {
        $transaction->updateStore($this->find($transaction->id)->toArray());
    }
}
