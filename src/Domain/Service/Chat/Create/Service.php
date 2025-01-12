<?php

declare(strict_types=1);

namespace App\Domain\Service\Chat\Create;

use App\Domain\Entity\Chat;
use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Service
{
    public function __construct(
        public EntityManagerInterface $em,
    )
    {
    }

    public function __invoke(string $name, User $user): Chat
    {
        $chat = new Chat();
        $chat->setName($name)
            ->setOwner($user);

        $this->em->persist($chat);
        $this->em->flush();

        return $chat;
    }
}