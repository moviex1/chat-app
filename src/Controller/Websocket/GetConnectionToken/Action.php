<?php

declare(strict_types=1);

namespace App\Controller\Websocket\GetConnectionToken;

use App\Infrastructure\Centrifugo\CentrifugoClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class Action extends AbstractController
{
    #[Route(path: '/api/websocket/connect', name: 'websocket_connect', methods: ['GET'])]
    public function __invoke(
        CentrifugoClient $centrifugo,
    ): JsonResponse
    {
        $user = $this->getUser();

        $token = $centrifugo->generateConnectionToken(id: $user->getUserIdentifier());

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}