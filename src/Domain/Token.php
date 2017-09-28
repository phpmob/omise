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
 * @property string id
 * @property bool livemode
 * @property bool used
 * @property Card card
 * @property string datetime
 */
class Token extends Model
{
    /**
     * @return array
     */
    public function getCreateData()
    {
        return [
            'card' => [
                'name' => $this->card->name,
                'number' => $this->card->number,
                'expiration_month' => $this->card->expirationMonth,
                'expiration_year' => $this->card->expirationYear,
                'city' => $this->card->city,
                'postal_code' => $this->card->postalCode,
                'security_code' => $this->card->securityCode,
            ],
        ];
    }
}
