<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Domain;

use PhpMob\Omise\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 *
 * @property string object
 * @property string id
 * @property boolean livemode
 * @property string location
 * @property string defaultCard
 * @property string email
 * @property string description
 * @property string metadata
 * @property string created
 * @property Pagination cards
 *
 * @property string cardToken
 */
class Customer extends Model
{
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
