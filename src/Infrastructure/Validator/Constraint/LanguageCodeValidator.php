<?php

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Intl\Languages;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LanguageCodeValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var $constraint LanguageCode */

        if (null === $value || '' === $value) {
            return;
        }

        if (!preg_match('/^[a-z]{2}(-[A-Z]{2})?$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

        if (!Languages::exists($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
