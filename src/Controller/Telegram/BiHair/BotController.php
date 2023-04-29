<?php

namespace App\Controller\Telegram\BiHair;

use App\Domain\Telegram\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\TelegramBotManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bihair')]
class BotController extends AbstractController
{
    #[Route('/process-update', methods: [Request::METHOD_POST])]
    public function processUpdate(
        Request $request,
        BiHairBotProvider $bot,
        TelegramBotManager $telegramBotManager
    ) : Response {
        if (!$response = $request->getContent()) {
            return new Response('Bad Request', 403);
        }

        $update = json_decode($response, true);
        if (json_last_error() === JSON_THROW_ON_ERROR) {
            return new Response('Bad Request', 403);
        }

        if ($updateDto = $telegramBotManager->createUpdate($update)) {
            $telegramBotManager->processUpdate($updateDto, $bot);
        }

        return new Response('OK', 200);
    }
}