<?php

namespace App\Infrastructure\Security\Exception;

class TokenAdapterUnsupportedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No supported token adapter found');
    }
}
