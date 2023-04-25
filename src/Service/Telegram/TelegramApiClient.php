<?php
namespace App\Service\Telegram;

use App\Domain\BiHairBot\MessageDto;

class TelegramApiClient
{
    public function __construct()
    {
    }

    /**
     * @param string     $chatId
     * @param MessageDto $messageDto
     *
     * @return void
     */
    public function sendMessage(string $chatId, MessageDto $messageDto)
    {
        //send message to bot $messageDto->getText()
    }
}
