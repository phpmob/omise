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

use PhpMob\Omise\Country;
use PhpMob\Omise\Currency;
use PhpMob\Omise\Exception\InvalidRequestArgumentException;
use PhpMob\Omise\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @property string object
 * @property string id
 * @property string type
 * @property string flow
 * @property integer amount
 * @property string currency
 */
class Source extends Model
{
    /**
     * @param string $countryCode
     *
     * @return array
     */
    public function getCreateData($countryCode = Country::TH)
    {
        if (!in_array($this->currency, Currency::getSupporteds($countryCode))) {
            throw new InvalidRequestArgumentException(
                sprintf('The currency `%s` is not supported in your country `%s`.', $this->currency, $countryCode)
            );
        }

        return [
            'amount' => $this->amount * Currency::getDivisionOffset($this->currency),
            'currency' => $this->currency,
            'type' => $this->type,
        ];
    }
}
