<?php

namespace App\Infrastructure\Security\Exception;


class TokenAdapterNotFoundException extends \Exception
{
    public function __construct(string $tokenName)
    {
        parent::__construct(sprintf('Token adapter %s not found', $tokenName));
    }
}