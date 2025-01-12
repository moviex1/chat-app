<?php

declare(strict_types=1);

namespace App\Domain\Service\Chat\GetChannelToken;

use App\Domain\Entity\Chat;
use App\Domain\Entity\User;
use App\Domain\Repository\ChatRepository;
use App\Infrastructure\Centrifugo\CentrifugoClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class Service
{
    public function __construct(
        public ChatRepository $chatRepository,
        public CentrifugoClient $centrifugo,
    )
    {
    }

    public function __invoke(string $chatId, User $user): string
    {
        $chat = $this->chatRepository->find($chatId);

        if ($chat === null) {
            throw new NotFoundHttpException('Chat not found');
        }
        $chatId = $chat->getId();

        return $this->centrifugo->generateSubscriptionToken(id: $user->getUserIdentifier(), channel: "chat#$chatId");
    }
}