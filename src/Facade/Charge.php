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

use PhpMob\Omise\Domain\Charge as Domain;
use PhpMob\Omise\Facade;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @mixin Domain
 *
 * @method static Pagination all(array $parameters = [])
 * @method static Charge find($id)
 * @method void refresh()
 * @method void update()
 * @method void capture()
 * @method void reverse()
 * @method void create()
 * @method void createUsingToken()
 * @method void createUsingCustomer()
 * @method void createUsingCustomerAndCard()
 */
class Charge extends Facade
{
}
