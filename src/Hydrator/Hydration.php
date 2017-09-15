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

use PhpMob\Omise\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Hydration implements HydrationInterface
{
    /**
     * TODO: improve me
     * @param array $data
     *
     * @return array
     */
    private function doHydrate(array &$data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = self::doHydrate($data[$key]);
            }
        }

        if (empty($data) || empty($data['object'])) {
            return $data;
        }

        $domain = $this->makeDomainClass($data['object']);

        return new $domain($data);
    }

    /**
     * @param string $rawData
     *
     * @return Model|mixed
     */
    public function hydrate($rawData)
    {
        $data = json_decode($rawData, true);

        return $this->doHydrate($data);
    }

    /**
     * @param $className
     *
     * @return string
     */
    protected function makeDomainClass($className)
    {
        return "PhpMob\\Omise\\Domain\\".ucfirst(
                $className === 'list' ? 'Pagination' : $className
            );
    }
}
