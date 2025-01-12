<?php

declare(strict_types=1);

namespace App\Controller\Chat\Create;

use App\Domain\Entity\Chat;
use App\Domain\Entity\User;
use App\Domain\Service\Chat\Create\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class Action extends AbstractController
{
    #[Route(path: '/api/chat', name: 'create_chat', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload]
        Request $request,
        Service $service,
    ): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        $chat = $service($request->name, $user);

        return new JsonResponse([
            'id' => $chat->getId(),
            'name' => $chat->getName(),
        ]);
    }
}