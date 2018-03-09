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

use PhpMob\Omise\Currency;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ChargeLimitValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint|ChargeLimit $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!\is_array($value) && !\is_object($value)) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        $amount = $accessor->getValue($value, $constraint->amountField);
        $currency = $accessor->getValue($value, $constraint->currencyField);

        if (!\in_array(\strtolower($currency), [Currency::THB, Currency::JPY, Currency::SGD])) {
            // https://www.omise.co/currency-and-amount
            // ... todo: how we can do? ... now forward to api side error!
            return;
        }

        $amount = $amount * ($constraint->divisor ? $constraint->divisor : 1);
        list($min, $max) = Currency::getMinMaxs($currency);
        $divisor = Currency::getDivisionOffset($currency);

        if ($amount < $min) {
            $this->context->buildViolation($constraint->minMessage)
                ->atPath($constraint->amountField)
                ->setParameter('{{ amount }}', number_format($min / $divisor))
                ->setParameter('{{ currency }}', $currency)
                ->addViolation();
            return;
        }

        if ($amount > $max) {
            $this->context->buildViolation($constraint->maxMessage)
                ->atPath($constraint->amountField)
                ->setParameter('{{ amount }}', number_format($max / $divisor))
                ->setParameter('{{ currency }}', $currency)
                ->addViolation();
            return;
        }
    }
}
