<?php

namespace App\Domain\Interface;

use Symfony\Component\Security\Core\User\UserInterface;

interface NotifierInterface
{
    public function addReceiver(UserInterface $receiver): void;

    public function setSender(UserInterface $sender): void;

    public function notify(string $message, string $title = null): void;

    public function getName(): string;
}
