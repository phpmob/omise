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

use PhpMob\Omise\Domain\Error;
use PhpMob\Omise\Exception\InvalidResponseException;
use PhpMob\Omise\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Hydration implements HydrationInterface
{
    /**
     * TODO: improve me
     *
     * @param array $data
     *
     * @return Model|array
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

        $domain = static::getDomainClass($data['object']);

        return new $domain($data);
    }

    /**
     * @param string $rawData
     *
     * @return Model
     *
     * @throws InvalidResponseException
     */
    public function hydrate($rawData)
    {
        $data = json_decode($rawData, true);
        $domain = $this->doHydrate($data);
        $assertingClass = static::getDomainAssertionClass();

        if (!$domain instanceof $assertingClass) {
            throw new InvalidResponseException(new Error([
                'code' => 'unsupported_format',
                'message' => 'Unsupported format.',
                'data' => $domain,
            ]));
        }

        return $domain;
    }

    /**
     * @param $className
     *
     * @return string
     */
    public static function getDomainClass($className)
    {
        return 'PhpMob\\Omise\\Domain\\' . ucfirst($className === 'list' ? 'Pagination' : $className);
    }

    /**
     * @return string
     */
    public static function getDomainAssertionClass()
    {
        return Model::class;
    }
}
