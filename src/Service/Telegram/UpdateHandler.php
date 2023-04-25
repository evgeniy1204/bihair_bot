<?php

namespace App\Service\Telegram;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UpdateHandler
{
    private const SUPPORTED_TYPES = [
        'message'
    ];

    private array $UpdatesDto;

    /**
     * @param TelegramApiClient $telegram
     */
    public function __construct
    (
        #[Autowire(service: 'telegram')]
        private TelegramApiClient $telegram
    ) {
    }

    /**
     * @return array
     */
    public function handle() : array
    {
        $updates = json_decode($this->telegram->getUpdates(), true)['result'];
        $this->processUpdates($updates);
        return $this->UpdatesDto;
    }

    /**
     * @param array $updates
     * @return void
     */
    private function processUpdates(array $updates) : void
    {
        foreach ($updates as $update) {
            if (!array_intersect(array_keys($update), self::SUPPORTED_TYPES)) {
                continue;
            }
            $this->UpdatesDto[] = $this->processUpdate($update);
        }
    }

    /**
     * @param array $update
     * @return UpdateDto
     */
    private function processUpdate(array $update) : UpdateDto
    {
        $updateId = $update['update_id'];
        $userId = $update['message']['from']['id'];
        $text = $update['message']['text'];
        return new UpdateDto($updateId, $userId, $text);
    }

}