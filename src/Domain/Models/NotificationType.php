<?php

namespace App\Domain\Models;

use App\Domain\Interface\TimestampInterface;
use App\Domain\Models\ValueObject\NotificationType\NotificationTypeContent;
use App\Domain\Models\ValueObject\NotificationType\NotificationTypeId;
use App\Domain\Models\ValueObject\NotificationType\NotificationTypeName;
use App\Domain\Models\ValueObject\NotificationType\NotificationTypeSubject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class NotificationType implements TimestampInterface
{
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;
    private ?\DateTimeInterface $deletedAt;
    private NotificationTypeId $id;
    private NotificationTypeName $name;
    private ?NotificationTypeSubject $subject;
    private NotificationTypeContent $content;
    private Collection $notifications;

    public function __construct(
        NotificationTypeId $id,
        NotificationTypeName $name,
        NotificationTypeContent $content,
        ?NotificationTypeSubject $subject = null,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->content = $content;
        $this->subject = $subject;
        $this->notifications = new ArrayCollection();
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

    public function getId(): NotificationTypeId
    {
        return $this->id;
    }

    public function setId(NotificationTypeId $id): void
    {
        $this->id = $id;
    }

    public function getName(): NotificationTypeName
    {
        return $this->name;
    }

    public function setName(NotificationTypeName $name): void
    {
        $this->name = $name;
    }

    public function getSubject(): ?NotificationTypeSubject
    {
        return $this->subject;
    }

    public function setSubject(?NotificationTypeSubject $subject): void
    {
        $this->subject = $subject;
    }

    public function getContent(): NotificationTypeContent
    {
        return $this->content;
    }

    public function setContent(NotificationTypeContent $content): void
    {
        $this->content = $content;
    }

    /**
     * @return Notification[]
     */
    public function getNotifications(): array
    {
        return $this->notifications->toArray();
    }

    public function addNotification(Notification $notification): void
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setType($this);
        }
    }

    public function removeNotification(Notification $notification): void
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            $notification->setType(null);
        }
    }
}