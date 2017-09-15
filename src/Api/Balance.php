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
use PhpMob\Omise\Domain\Balance as Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @see https://www.omise.co/balance-api
 */
final class Balance extends Api
{
    /**
     * @return Model
     */
    public function fetch()
    {
        return $this->doRequest('GET', '/balance');
    }

    /**
     * @param Model $account
     */
    public function refresh(Model $account)
    {
        $account->updateStore($this->fetch()->toArray());
    }
}
