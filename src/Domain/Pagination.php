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
 * @property string from
 * @property string to
 * @property int offset
 * @property int limit
 * @property int total
 * @property Model[]|array data
 */
class Pagination extends Model implements \Countable
{
    /**
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }
}
