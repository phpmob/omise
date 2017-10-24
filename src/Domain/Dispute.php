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
 * @property string id
 * @property bool livemode
 * @property string location
 * @property int amount
 * @property string currency
 * @property string status
 * @property string message
 * @property string metadata
 * @property string charge
 * @property string created
 */
class Dispute extends Model
{
    /**
     * @return array
     */
    public function getUpdateData()
    {
        return [
            'description' => $this->message,
            'metadata' => $this->metadata,
        ];
    }
}
