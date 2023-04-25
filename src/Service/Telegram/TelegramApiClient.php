<?php
namespace App\Service\Telegram;

use App\Domain\BiHairBot\MessageDto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TelegramApiClient
{
    /**
     * @param Client $client
     */
    public function __construct(
        #[Autowire(service: 'guzzle.client')]
        private Client $client
    )
    {
    }

    /**
     * @param string $chatId
     * @param MessageDto $messageDto
     *
     * @return void
     * @throws GuzzleException
     */
    public function sendMessage(string $chatId, MessageDto $messageDto): void
    {
        $this->client->request('GET', 'sendMessage',[
            'query' => [
                'chat_id' => $chatId,
                'text' => $messageDto->getText()
            ]
        ]);
    }

    /**
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function getUpdates(): StreamInterface
    {
        return $this->client->request('GET', 'getUpdates')->getBody();
    }
}
