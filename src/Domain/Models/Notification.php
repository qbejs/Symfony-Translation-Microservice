<?php

namespace App\Domain\Models;

use App\Domain\Interface\TimestampInterface;
use App\Domain\Models\ValueObject\Notification\NotificationId;
use App\Domain\Models\ValueObject\Notification\NotificationStatus;
use App\Domain\Models\ValueObject\Notification\Sender;
use Symfony\Component\Security\Core\User\UserInterface;

class Notification implements TimestampInterface
{
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;
    private ?\DateTimeInterface $deletedAt;
    private NotificationId $id;
    private ?NotificationType $type;
    private Sender $sender;
    private ?UserInterface $recipient;
    private NotificationStatus $status;

    public function __construct(
        NotificationId $id,
        Sender $sender,
        NotificationStatus $status,
        \DateTime $createdAt,
        \DateTime $updatedAt,
        ?\DateTime $deletedAt,
    ) {
        $this->id = $id;
        $this->sender = $sender;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getId(): NotificationId
    {
        return $this->id;
    }

    public function setId(NotificationId $id): void
    {
        $this->id = $id;
    }

    public function getType(): ?NotificationType
    {
        return $this->type;
    }

    public function setType(?NotificationType $type): void
    {
        $this->type = $type;
        $type->addNotification($this);
    }

    public function getSender(): Sender
    {
        return $this->sender;
    }

    public function setSender(Sender $sender): void
    {
        $this->sender = $sender;
    }

    public function getRecipient(): ?UserInterface
    {
        return $this->recipient;
    }

    public function setRecipient(?UserInterface $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getStatus(): NotificationStatus
    {
        return $this->status;
    }

    public function setStatus(NotificationStatus $status): void
    {
        $this->status = $status;
    }
}