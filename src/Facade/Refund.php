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

use PhpMob\Omise\Domain\Refund as Domain;
use PhpMob\Omise\Facade;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @mixin Domain
 *
 * @method static Pagination all(array $parameters = [])
 * @method static Pagination charge($chargeId, array $parameters = [])
 * @method static Refund find($chargeId, $id)
 * @method void refresh()
 * @method void create()
 */
class Refund extends Facade
{
}
