<?php

namespace App\Controller\BiHairBot;

use App\Service\Telegram\TelegramBotManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bihair')]
class BotController extends AbstractController
{
    public function __construct(
        private readonly TelegramBotManager $telegramBotManager
    )
    {
    }

    #[Route('/process-update', methods: ['POST'])]
    public function processUpdate(Request $request)
    {
        if (!$request->getContent()) {
            return new Response('Bad Request', 400);
        }
        $update = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new Response('Bad Request', 400);
        }
        $this->telegramBotManager->handle($update);
        return new Response($update, 200);
    }
}