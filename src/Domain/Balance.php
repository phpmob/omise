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
 * @property bool livemode
 * @property string location
 * @property int available
 * @property int total
 * @property string currency
 *
 * @method static Balance fetch
 * @method void refresh()
 */
class Balance extends Model
{
}
