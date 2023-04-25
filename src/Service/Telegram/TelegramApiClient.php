<?php
namespace App\Service\Telegram;

use App\Domain\BiHairBot\MessageDto;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TelegramApiClient
{
    public function __construct(
        #[Autowire(service: 'guzzle.client')]
        private Client $client
    )
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
        $this->client->request('GET', 'sendMessage',[
            'query' => [
                'chat_id' => $chatId,
                'text' => $messageDto->getText()
            ]
        ]);
    }

    public function getUpdates()
    {
        return $this->client->request('GET', 'getUpdates')->getBody();
    }
}
