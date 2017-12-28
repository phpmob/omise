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
 * @property string id
 * @property string object
 * @property bool livemode
 * @property string location
 * @property string status
 * @property int amount
 * @property string currency
 * @property string description
 * @property string metadata
 * @property bool capture
 * @property bool authorized
 * @property bool reversed
 * @property bool paid
 * @property string transaction
 * @property Card card
 * @property int refunded
 * @property Pagination refunds
 * @property string failureCode
 * @property string failureMessage
 * @property Customer customer
 * @property string ip
 * @property Dispute dispute
 * @property string created
 * @property string returnUri
 * @property string authorizeUri
 * @property string $cardToken
 * @property Source $source
 */
class Charge extends Model
{
    const STATUS_FAILED = 'failed';
    const STATUS_EXPIRED = 'expired';
    const STATUS_PENDING = 'pending';
    const STATUS_REVERSED = 'reversed';
    const STATUS_SUCCESSFUL = 'successful';

    const EVENT_CREATE = 'charge.create';
    const EVENT_UPDATE = 'charge.update';
    const EVENT_CAPTURE = 'charge.capture';
    const EVENT_REVERSE = 'charge.reverse';
    const EVENT_COMPLETE = 'charge.complete';

    /**
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {
        if ('currency' === $name) {
            $value = strtolower($value);
        }

        parent::__set($name, $value);
    }

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
            'customer' => (string)($this->customer),
            'card' => $this->card,
            'amount' => intval($this->amount * Currency::getDivisionOffset($this->currency)),
            'currency' => $this->currency,
            'description' => $this->description,
            'metadata' => $this->metadata,
            'capture' => $this->capture,
            'return_uri' => $this->returnUri,
        ];
    }

    /**
     * @param string $countryCode
     *
     * @return array
     */
    public function getCreateUsingTokenData($countryCode = Country::TH)
    {
        $data = $this->getCreateData($countryCode);
        $data['card'] = $this->cardToken;

        unset($data['customer']);

        return $data;
    }

    /**
     * @param string $countryCode
     *
     * @return array
     */
    public function getCreateUsingSourceData($countryCode = Country::TH)
    {
        $data = $this->getCreateData($countryCode);
        $data['source'] = $this->source->id;

        unset($data['card'], $data['customer']);

        return $data;
    }

    /**
     * @return array
     */
    public function getUpdateData()
    {
        return [
            'description' => $this->description,
            'metadata' => $this->metadata,
        ];
    }

    /**
     * @return array|Refund[]
     */
    public function getRefunds()
    {
        if (count($this->refunds)) {
            return $this->refunds->data;
        }

        return [];
    }

    /**
     * @param $id
     *
     * @return Refund|null
     */
    public function findRefunds($id)
    {
        $charge = array_filter(
            $this->getRefunds(),
            function (Refund $charge) use ($id) {
                return $charge->id === $id;
            }
        );

        if (empty($charge)) {
            return null;
        }

        return $charge[0];
    }
}
