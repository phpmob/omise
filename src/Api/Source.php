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

namespace PhpMob\Omise\Api;

use PhpMob\Omise\Api;
use PhpMob\Omise\Domain\Source as Domain;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @see https://www.omise.co/source-api
 */
final class Source extends Api
{
    /**
     * @param Domain $source
     */
    public function create(Domain $source)
    {
        $source->updateStore($this->doRequest('POST', '/sources', $source->getCreateData($this->countryCode))->toArray());
    }
}
