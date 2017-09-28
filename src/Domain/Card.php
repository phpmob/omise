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
 * @see https://www.omise.co/cards-api
 *
 * @property string object
 * @property string id
 * @property bool livemode
 * @property string location
 * @property string country
 * @property string city
 * @property string bank
 * @property string postalCode
 * @property string financing
 * @property string lastDigits
 * @property string brand
 * @property int expirationMonth
 * @property int expirationYear
 * @property string fingerprint
 * @property string name
 * @property string created
 * @property bool deleted
 * @property Customer $customer
 * @property string $number
 * @property int $securityCode
 */
class Card extends Model
{
    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var int
     */
    protected $securityCode;

    /**
     * @return array
     */
    public function getUpdateData()
    {
        return [
            'name' => $this->name,
            'expiration_month' => $this->expirationMonth,
            'expiration_year' => $this->expirationYear,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
        ];
    }
}
