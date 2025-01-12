<?php

declare(strict_types=1);

namespace App\Controller\Message\Send;

use App\Domain\Entity\Message;
use App\Domain\Entity\User;
use App\Domain\Repository\ChatRepository;
use App\Domain\Service\Message\Send\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class Action extends AbstractController
{
    #[Route(path: '/api/chat/{chatId}/message', name: 'send_message', methods: ['POST'])]
    public function __invoke(
        string $chatId,
        #[MapRequestPayload]
        Request $request,
        Service $service,
    ): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        $message = $service($chatId, $request->content, $user);

        return new JsonResponse([
            'messageId' => $message->getId(),
        ]);
    }
}