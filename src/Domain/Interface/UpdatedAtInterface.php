<?php

namespace App\Domain\Interface;

interface UpdatedAtInterface
{
    public function setUpdatedAt(\DateTime $updatedAt): void;
    public function getUpdatedAt(): \DateTime;
}