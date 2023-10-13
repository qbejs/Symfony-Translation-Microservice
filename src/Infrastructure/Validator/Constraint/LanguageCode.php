<?php

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class LanguageCode extends Constraint
{
    public string $message = 'The language code "{{ value }}" is not valid.';
}
