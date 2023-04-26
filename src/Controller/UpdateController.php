<?php

namespace App\Controller;

use App\Service\Telegram\TelegramBotManager;
use App\Service\Telegram\UpdateHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    /**
     * @param TelegramBotManager $telegramBotManager
     */
    public function __construct(
        private readonly TelegramBotManager $telegramBotManager
    ) {
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'processUpdate', methods: ['POST'])]
    public function processUpdate(Request $request): Response
    {
        if ($request->getMethod() != 'POST') {
            return new Response('Method Not Allowed', 405);
        }
        if (!$request->getContent()) {
            return new Response('Bad Request', 400);
        }
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new Response('Bad Request', 400);
        }
        $update = UpdateHandler::processUpdate($data);
        $this->telegramBotManager->handleWebHook($update);
        return new Response('OK', 200);
    }

}