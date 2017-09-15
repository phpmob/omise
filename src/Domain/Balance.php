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
 * @property boolean livemode
 * @property string location
 * @property integer available
 * @property integer total
 * @property string currency
 *
 * @method static Balance fetch
 * @method void refresh()
 */
class Balance extends Model
{
}
