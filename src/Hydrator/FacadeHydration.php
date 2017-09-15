<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\Omise\Hydrator;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FacadeHydration extends Hydration
{
    /**
     * @param $objectName
     *
     * @return string
     */
    protected function makeDomainClass($objectName)
    {
        if ('error' === $objectName) {
            return parent::makeDomainClass($objectName);
        }

        return "PhpMob\\Omise\\Facade\\".ucfirst($objectName === 'list' ? 'Pagination' : $objectName);
    }
}
