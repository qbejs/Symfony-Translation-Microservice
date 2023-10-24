<?php

namespace App\Domain\Interface;

use App\Domain\Models\NotificationType;

interface NotificationTypeRepositoryInterface
{
    public function find(int $id): ?NotificationType;

    public function findAll(): array;

    public function save(NotificationType $notificationType): void;

    public function delete(NotificationType $notificationType): void;
}
