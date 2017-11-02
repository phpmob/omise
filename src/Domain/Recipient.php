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
 * @property bool verified
 * @property bool active
 * @property string name
 * @property string email
 * @property string description
 * @property string type
 * @property string taxId
 * @property BankAccount bankAccount
 * @property string failureCode
 * @property string created
 * @property string metadata
 */
class Recipient extends Model
{
    const EVENT_CREATE = 'charge.create';
    const EVENT_UPDATE = 'charge.update';
    const EVENT_DESTROY = 'charge.destroy';
    const EVENT_ACTIVATE = 'charge.activate';
    const EVENT_DEACTIVATE = 'charge.deactivate';
    const EVENT_VERIFY = 'charge.verify';

    /**
     * @return array
     */
    public function getCreateData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'type' => $this->type,
            'tax_id' => $this->taxId,
            'bank_account' => $this->bankAccount,
            'metadata' => $this->metadata,
        ];
    }

    /**
     * @return array
     */
    public function getUpdateData()
    {
        return $this->getCreateData();
    }
}
