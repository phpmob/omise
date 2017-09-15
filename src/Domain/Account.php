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
 * @property string location
 * @property string email
 * @property string currency
 * @property string created
 *
 * @method static Account fetch
 * @method void refresh()
 */
class Account extends Model
{
}
