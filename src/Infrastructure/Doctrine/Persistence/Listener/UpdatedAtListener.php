<?php

namespace App\Infrastructure\Doctrine\Persistence\Listener;

use App\Domain\Interface\TimestampInterface;
use DateTime;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UpdatedAtListener
{
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof TimestampInterface) {
            $entity->setUpdatedAt(new DateTime());
        }
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof TimestampInterface) {
            $entity->setUpdatedAt(new DateTime());
        }
    }
}
