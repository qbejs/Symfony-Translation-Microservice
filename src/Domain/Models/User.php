<?php

namespace App\Domain\Models;

use App\Domain\Interface\TimestampInterface;
use App\Domain\Models\ValueObject\User\Email;
use App\Domain\Models\ValueObject\User\Password;
use App\Domain\Models\ValueObject\User\Roles;
use App\Domain\Models\ValueObject\User\UserId;
use App\Domain\Models\ValueObject\User\Username;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, TimestampInterface, PasswordAuthenticatedUserInterface
{
    private ?UserId $id;
    private Username $username;
    private ?Password $password;
    private Email $email;
    private Roles $roles;
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;
    private ?\DateTimeInterface $deletedAt;
    private Collection $notifications;

    public function __construct(
        ?UserId $id,
        Username $username,
        ?Password $password,
        Email $email,
        Roles $roles,
        \DateTimeInterface $createdAt,
        \DateTimeInterface $updatedAt,
        ?\DateTimeInterface $deletedAt
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->roles = $roles;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?UserId
    {
        return $this->id;
    }

    public function setId(?UserId $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function setUsername(Username $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password->getValue();
    }

    public function getPasswordObject(): ?Password
    {
        return $this->password;
    }

    public function setPassword(?Password $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return $this->roles->getValues();
    }

    public function setRoles(Roles $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
        $this->password = new Password('');
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return $this->email->getValue();
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
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
            $notification->setRecipient($this);
        }
    }

    public function removeNotification(Notification $notification): void
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            $notification->setRecipient(null);
        }
    }

}