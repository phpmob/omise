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
 * @author Saranyu <Saranyuphimsahwan@gmail.com>
 *
 * @property string object
 * @property string id
 * @property string location
 * @property string type
 * @property int amount
 * @property string currency
 * @property string transferable
 * @property string created
 */
class Transaction extends Model
{
}
