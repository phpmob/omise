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

namespace PhpMob\Omise\Hydrator;

use PhpMob\Omise\Facade;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FacadeHydration extends Hydration
{
    /**
     * {@inheritdoc}
     */
    public static function getDomainClass($objectName)
    {
        if ('error' === $objectName) {
            return parent::getDomainClass($objectName);
        }

        return 'PhpMob\\Omise\\Facade\\' . ucfirst($objectName === 'list' ? 'Pagination' : $objectName);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDomainAssertionClass()
    {
        return Facade::class;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDomainAssertionClass()
    {
        return Facade::class;
    }
}
