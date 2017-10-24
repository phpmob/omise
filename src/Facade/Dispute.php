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
use PhpMob\Omise\Domain\Dispute as Domain;

/**
 * @author Saranyu <Saranyuphimsahwan@gmail.com>
 *
 * @mixin Domain
 * @method static Pagination all(array $parameters = [])
 * @method static Pagination opens(array $parameters = [])
 * @method static Pagination pendings(array $parameters = [])
 * @method static Pagination closeds(array $parameters = [])
 * @method static Dispute find($id)
 * @method void refresh()
 * @method void update()
 */
class Dispute extends Facade
{
}
