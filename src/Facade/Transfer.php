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
use PhpMob\Omise\Domain\Transfer as Domain;

/**
 * @author Prawit <tongmomo001@gmail.com>
 *
 * @mixin Domain
 * @method static Pagination all(array $parameters = [])
 * @method static Transfer find($id)
 * @method void refresh()
 * @method void create()
 * @method void createWithRecipient()
 * @method void update()
 * @method void destroy()
 */
class Transfer extends Facade
{
}
