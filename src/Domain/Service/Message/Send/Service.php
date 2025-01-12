<?php

declare(strict_types=1);

namespace App\Domain\Service\Message\Send;

use App\Domain\Entity\Message;
use App\Domain\Entity\User;
use App\Domain\Repository\ChatRepository;
use App\Infrastructure\Centrifugo\CentrifugoClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class Service
{
    public function __construct(
        public ChatRepository $chatRepository,
        public EntityManagerInterface $em,
        public CentrifugoClient $centrifugo,
    )
    {
    }

    public function __invoke(string $chatId, string $content, User $sender): Message
    {
        $chat = $this->chatRepository->find($chatId);
        if ($chat === null) {
            throw new NotFoundHttpException('Chat not found');
        }

        $message = new Message();
        $message->setContent($content)
            ->setSender($sender)
            ->setChat($chat);

        $this->em->persist($message);
        $this->em->flush();

        $this->centrifugo->publish("chat#$chatId", [
            'username' => $sender->getUsername(),
            'content' => $message->getContent(),
        ]);

        return $message;
    }
}