<?php

namespace App\Controller\BiHair;

use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\TelegramBotManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bihair')]
class BotController extends AbstractController
{
    /**
     * @param TelegramBotManager $telegramBotManager
     */
    public function __construct(
        private readonly TelegramBotManager $telegramBotManager
    )
    {
    }

    /**
     * @param Request $request
     * @param BiHairBotProvider $bot
     * @return Response
     */
    #[Route('/process-update', methods: ['POST'])]
    public function processUpdate(Request $request, BiHairBotProvider $bot) : Response
    {
        if (!$response = $request->getContent()) {
            return new Response('Bad Request', 403);
        }

        $update = json_decode($response, true);
        if (json_last_error() === JSON_THROW_ON_ERROR) {
            return new Response('Bad Request', 403);
        }

        $updateDto = $this->telegramBotManager->createUpdate($update);
        $this->telegramBotManager->processUpdate($updateDto, $bot);

        return new Response('OK', 200);
    }
}