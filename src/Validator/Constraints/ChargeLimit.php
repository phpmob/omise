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

namespace PhpMob\Omise\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class ChargeLimit extends Constraint
{
    public $minMessage = 'Amount must be greater than or equal to {{ amount }} ({{ currency }}).';
    public $maxMessage = 'Amount must be less than or equal to {{ amount }} ({{ currency }}).';
    public $amountField = 'amount';
    public $currencyField = 'currencyCode';
    public $divisor = 0;

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
