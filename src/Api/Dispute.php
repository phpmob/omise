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
use PhpMob\Omise\Domain\Dispute as Domain;
use PhpMob\Omise\Domain\Pagination;

/**
 * @author Saranyu <saranyuphimsahwan@gmail.com>
 *
 * @see https://www.omise.co/disputes-api
 */
final class Dispute extends Api
{
    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function all(array $parameters = [])
    {
        return $this->doRequest('GET', '/disputes', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function opens(array $parameters = [])
    {
        return $this->doRequest('GET', '/disputes/open', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function pendings(array $parameters = [])
    {
        return $this->doRequest('GET', '/disputes/pending', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return Pagination
     */
    public function closeds(array $parameters = [])
    {
        return $this->doRequest('GET', '/disputes/closed', $parameters);
    }

    /**
     * @param string $id
     *
     * @return Domain
     */
    public function find($id)
    {
        self::assertNotEmpty($id);

        return $this->doRequest('GET', '/disputes/'.$id);
    }

    /**
     * @param Domain $dispute
     */
    public function refresh(Domain $dispute)
    {
        $dispute->updateStore($this->find($dispute->id)->toArray());
    }

    /**
     * @param Domain $dispute
     */
    public function update(Domain $dispute)
    {
        self::assertNotEmpty($dispute->id);

        $dispute->updateStore($this->doRequest('PATCH', '/disputes/'.$dispute->id, $dispute->getUpdateData())->toArray());
    }
}
