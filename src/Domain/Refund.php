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
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @property string object
 * @property string id
 * @property string message
 * @property string code
 * @property string location
 * @property int amount
 * @property string currency
 * @property bool voided
 * @property Charge charge
 * @property string transactionId
 */
class Refund extends Model
{
    const EVENT_CREATE = 'charge.create';
}
