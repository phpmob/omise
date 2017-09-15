<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Facade;

use PhpMob\Omise\Facade;
use PhpMob\Omise\Domain\Token as Domain;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @mixin Domain
 * @method static Token find($id)
 * @method void refresh()
 * @method void create()
 */
class Token extends Facade
{
}
