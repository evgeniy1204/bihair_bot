<?php
namespace App\Service\Telegram;

use GuzzleHttp\Client;
use LogicException;

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
    public function __construct(private readonly string $token)
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

        $updates = json_decode($updates, true);
        if (!$updates['ok']) {
            return [];
        }
        $results = $updates['result'];
        $updatesDto = [];
        foreach ($results as $result) {
            $updatesDto[] = $this->processUpdate($result);
        }

        return $updatesDto;
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
    private function processUpdate(array $result): UpdateDto
    {
        $callbackData = null;
        if ($result['callback_query'] ?? null) {
            $callbackData = $result['callback_query']['data'];

            return new UpdateDto($result['update_id'], $result['callback_query']['message']['chat']['id'], $callbackData);
        }
        $chatId = $result['message']['chat']['id'] ?? null;
        $key = $callbackData ?? $result['message']['text'] ?? null;
        $id = $result['update_id'] ?? null;

        if ($id && $chatId && $key) {
            return new UpdateDto($id, $chatId, $key);
        }
        throw new LogicException();
    }
}
