<?php

namespace App\Infrastructure\Security\Exception;


class BlacklistAdapterUnsupportedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No supported token blacklist adapter found');
    }
}