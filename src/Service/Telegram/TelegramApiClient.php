<?php

namespace App\Service\Telegram;

use GuzzleHttp\Client;
use LogicException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TelegramApiClient
{
    private const TELEGRAM_HOST = 'https://api.telegram.org/bot';

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @param string $token
     */
    public function __construct(
        private readonly string $token,
    )
    {
        $this->client = new Client();
    }

    /**
     * @param MessageDto $messageDto
     *
     * @return void
     */
    public function sendMessage(MessageDto $messageDto): void
    {
        try {
            $this->client->post($this->getUri() . DIRECTORY_SEPARATOR . 'sendMessage', [
                'form_params' => [
                    'chat_id' => $messageDto->getChatId(),
                    'text' => $messageDto->getText(),
                    'reply_markup' => json_encode($messageDto->buildMarkUp(), JSON_THROW_ON_ERROR),
                ],
            ]);
            if ($messageDto->getPhotoId()) {
                $this->client->post($this->getUri() . DIRECTORY_SEPARATOR . 'sendPhoto', [
                    'form_params' => [
                        'chat_id' => $messageDto->getChatId(),
                        'photo' => $messageDto->getPhotoId(),
                    ],
                ]);
            }
        } catch (\Throwable $throwable) {
            throw new \LogicException($throwable->getMessage());
        }
    }

    /**
     * @param int|null $offset
     *
     * @return UpdateDto[]
     */
    public function getUpdates(?int $offset): array
    {
        try {
            $updates = $this->client->get($this->getUri() . DIRECTORY_SEPARATOR . 'getUpdates', [
                'query' => [
                    'offset' => $offset,
                    'allowed_updates' => ['message', 'callback_query'],
                ],
            ])->getBody()->getContents();
        } catch (\Throwable $throwable) {
            throw new \LogicException($throwable->getMessage());
        }

        return updateHandler::processUpdates($updates);
    }

    /**
     * @return string
     */
    private function getUri(): string
    {
        return sprintf('%s%s', self::TELEGRAM_HOST, $this->token);
    }

    /**
     * @param array $result
     *
     * @return UpdateDto
     */

}
