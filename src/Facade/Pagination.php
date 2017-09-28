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

namespace PhpMob\Omise\Facade;

use PhpMob\Omise\Domain\Pagination as Domain;
use PhpMob\Omise\Facade;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @mixin Domain
 *
 * @property Domain $domain
 */
class Pagination extends Facade implements \Countable
{
    /**
     * @return int
     */
    public function count()
    {
        return $this->domain->count();
    }
}
