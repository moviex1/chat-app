<?php

declare(strict_types=1);

namespace App\Controller\Chat\GetChannelToken;


use App\Domain\Entity\User;
use App\Domain\Repository\ChatRepository;
use App\Domain\Service\Chat\GetChannelToken\Service;
use App\Infrastructure\Centrifugo\CentrifugoClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class Action extends AbstractController
{
    #[Route(path: '/api/chat/{chatId}/token', name: 'chat.token', methods: ['GET'])]
    public function __invoke(
        string $chatId,
        Service $service,
    ): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        return new JsonResponse([
            'token' => $service($chatId, $user),
        ]);
    }
}