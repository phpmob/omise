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
use PhpMob\Omise\Domain\Token as Domain;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @see https://www.omise.co/tokens-api
 */
final class Token extends Api
{
    /**
     * @var bool
     */
    protected $isSensitive = true;

    /**
     * @param string $id
     *
     * @return Domain
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/tokens/'.$id);
    }

    /**
     * @param Domain $token
     */
    public function refresh(Domain $token)
    {
        $token->updateStore($this->find($token->id)->toArray());
    }

    /**
     * @param Domain $token
     */
    public function create(Domain $token)
    {
        $token->updateStore($this->doRequest('POST', '/tokens', $token->getCreateData())->toArray());
    }
}
