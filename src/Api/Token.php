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
use PhpMob\Omise\Domain\Token as Model;

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
     * @return Model
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/tokens/'.$id);
    }

    /**
     * @param Model $token
     */
    public function refresh(Model $token)
    {
        $token->updateStore($this->find($token->id)->toArray());
    }

    /**
     * @param Model $token
     */
    public function create(Model $token)
    {
        $token->updateStore($this->doRequest('POST', '/tokens', $token->getCreateData())->toArray());
    }
}
