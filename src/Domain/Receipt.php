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
 * @property string number
 * @property string location
 * @property string date
 * @property string customerName
 * @property string customerAddress
 * @property string customerTaxId
 * @property string customerEmail
 * @property string customerStatementName
 * @property string companyName
 * @property string companyAddress
 * @property string companyTaxId
 * @property int chargeFee
 * @property int voidedFee
 * @property int transferFee
 * @property int subtotal
 * @property int vat
 * @property int wht
 * @property int total
 * @property bool creditNote
 * @property string currency
 */
class Receipt extends Model
{
}
