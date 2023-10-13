<?php

namespace App\Infrastructure\Security\Adapter\BlacklistManager\Exception;

class UserTokenNotFound extends \Exception
{
    public function __construct()
    {
        parent::__construct('User with given token not found');
    }
}
