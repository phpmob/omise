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
 * @property bool livemode
 * @property string location
 * @property string defaultCard
 * @property string email
 * @property string description
 * @property string metadata
 * @property string created
 * @property Pagination cards
 * @property bool deleted
 * @property string cardToken
 */
class Customer extends Model
{
    const EVENT_CREATE = 'charge.create';
    const EVENT_UPDATE = 'charge.update';
    const EVENT_UPDATE_CARD = 'charge.update.card';
    const EVENT_DESTROY = 'charge.destroy';

    /**
     * @var string
     */
    protected $cardToken;

    /**
     * @return array
     */
    public function getCreateData()
    {
        return [
            'email' => $this->email,
            'description' => $this->description,
            'metadata' => $this->metadata,
            'card' => $this->__get('cardToken'),
        ];
    }

    /**
     * @return array
     */
    public function getUpdateData()
    {
        return $this->getCreateData();
    }

    /**
     * @return array|Card[]
     */
    public function getCards()
    {
        if (count($this->cards)) {
            return $this->cards->data;
        }

        return [];
    }

    /**
     * @param $id
     *
     * @return Card|null
     */
    public function findCard($id)
    {
        $cards = array_filter(
            $this->getCards(),
            function (Card $card) use ($id) {
                return $card->id === $id;
            }
        );

        if (empty($cards)) {
            return null;
        }

        return $cards[0];
    }
}
