<?php

namespace App\Domain\Models;

use App\Domain\Interface\UpdatedAtInterface;
use App\Domain\Models\ValueObject\User\Email;
use App\Domain\Models\ValueObject\User\Password;
use App\Domain\Models\ValueObject\User\Roles;
use App\Domain\Models\ValueObject\User\UserId;
use App\Domain\Models\ValueObject\User\Username;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, UpdatedAtInterface, PasswordAuthenticatedUserInterface
{
    private ?UserId $id;
    private Username $username;
    private ?Password $password;
    private Email $email;
    private Roles $roles;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
    private ?\DateTime $deletedAt;

    public function __construct(
        ?UserId $id,
        Username $username,
        ?Password $password,
        Email $email,
        Roles $roles,
        \DateTime $createdAt,
        \DateTime $updatedAt,
        ?\DateTime $deletedAt
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->roles = $roles;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
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

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt): void
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

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}