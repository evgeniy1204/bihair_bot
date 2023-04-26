<?php
namespace App\Service\Telegram;

use App\Domain\BiHairBot\MessageDto;
use App\Domain\BiHairBot\UpdateDto;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TelegramApiClient
{
    private const TELEGRAM_HOST = 'https://api.telegram.org/bot';

    /**
     * @var Client
     */
    private Client $client;

    private string $token;

    /**
     * @param string $token
     */
    public function __construct(
        #[Autowire('%env(TG_BIHAIR_BOT_TOKEN)%')]
        string $token,
    ) {
        $this->token = $token;
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
            $callbackData = null;
            if ($result['callback_query'] ?? null) {
                $callbackData = $result['callback_query']['data'];
                $updatesDto[] = new UpdateDto($result['update_id'], $result['callback_query']['message']['chat']['id'], $callbackData);

                continue;
            }
            $chatId = $result['message']['chat']['id'] ?? null;
            $key = $callbackData ?? $result['message']['text'] ?? null;
            $id = $result['update_id'] ?? null;

            if ($id && $chatId && $key) {
                $updatesDto[] = new UpdateDto($id, $chatId, $key);
            }
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
}
