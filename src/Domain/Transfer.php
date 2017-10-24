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

namespace PhpMob\Omise\Domain;

use PhpMob\Omise\Model;

/**
 * @author Prawit <tongmomo001@gmail.com>
 *
 * @property string object
 * @property string id
 * @property string livemode
 * @property string location
 * @property string recipient
 * @property BankAccount bankAccount
 * @property bool sent
 * @property bool paid
 * @property int amount
 * @property string currency
 * @property int fee
 * @property string failureCode
 * @property string failureMessage
 * @property string transaction
 * @property string created
 * @property string metadata
 */
class Transfer extends Model
{
    /**
     * @return array
     */
    public function getCreateData()
    {
        return [
            'amount' => $this->amount,
            'recipient' => $this->recipient,
            'metadata' => $this->metadata,
        ];
    }

    public function getUpdateData()
    {
        return [
            'amount' => $this->amount,
            'metadata' => $this->metadata,
        ];
    }
}
