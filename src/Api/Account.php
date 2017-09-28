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
use PhpMob\Omise\Domain\Account as Domain;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @see https://www.omise.co/account-api
 */
final class Account extends Api
{
    /**
     * @return Domain
     */
    public function fetch()
    {
        return $this->doRequest('GET', '/account');
    }

    /**
     * @param Domain $account
     */
    public function refresh(Domain $account)
    {
        $account->updateStore($this->fetch()->toArray());
    }
}
