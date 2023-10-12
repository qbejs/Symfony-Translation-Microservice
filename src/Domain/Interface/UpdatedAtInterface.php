<?php

namespace App\Domain\Interface;

interface UpdatedAtInterface
{
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void;
    public function getUpdatedAt(): \DateTimeInterface;
}