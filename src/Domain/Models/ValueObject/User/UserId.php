<?php

namespace App\Domain\Models\ValueObject\User;

class UserId
{
    private int $id;
    public function __construct(int $id)
    {
        if ($id < 1) {
            throw new \InvalidArgumentException('User id must be greater than 0');
        }

        $this->id = $id;
    }


    public function getValue(): string
    {
        return $this->id;
    }
}