<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Api;

use PhpMob\Omise\Api;
use PhpMob\Omise\Domain\Refund as Domain;
use PhpMob\Omise\Domain\Charge;
use PhpMob\Omise\Domain\Pagination;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @see https://www.omise.co/refunds-api
 */
final class Refund extends Api
{
    /**
     * @param string $chargeId
     * @param string $refundId
     *
     * @return string
     */
    private static function path($chargeId, $refundId)
    {
        return "/charges/$chargeId/refunds/$refundId";
    }

    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(array $parameters = [])
    {
        return $this->doRequest('GET', '/refunds', $parameters);
    }

    /**
     * @param Charge $charge
     * @param array $parameters
     *
     * @return Pagination
     */
    public function charge(Charge $charge, array $parameters = [])
    {
        self::assertNotEmpty($charge->id, 'Charge Id cannot be empty.');

        return $this->doRequest('GET', "/charges/$charge->id/refunds", $parameters);
    }

    /**
     * @param string $chargeId
     * @param string $id
     *
     * @return Domain
     */
    public function find($chargeId, $id)
    {
        self::assertNotEmpty($chargeId && $id, 'ChargeId Id or Id cannot be empty.');

        return $this->doRequest('GET', self::path($chargeId, $id));
    }

    /**
     * @param Domain $recipient
     */
    public function refresh(Domain $recipient)
    {
        $recipient->updateStore($this->find(@$recipient->charge->id, $recipient->id)->toArray());
    }
}
