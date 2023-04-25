<?php

namespace App\Service\Telegram;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UpdateHandler
{
    private const SUPPORTED_TYPES = [
        'message'
    ];

    private array $UpdatesDto;

    public function __construct
    (
        #[Autowire(service: 'telegram')]
        private TelegramApiClient $telegram
    ) {
    }

    public function handle()
    {
        $updates = json_decode($this->telegram->getUpdates(), true)['result'];
        $this->processUpdates($updates);
        return $this->UpdatesDto;
    }

    private function processUpdates(array $updates)
    {
        foreach ($updates as $update) {
            if (!array_intersect(array_keys($update), self::SUPPORTED_TYPES)) {
                continue;
            }
            $this->UpdatesDto[] = $this->processUpdate($update);
        }
    }

    private function processUpdate(array $update)
    {
        $updateId = $update['update_id'];
        $userId = $update['message']['from']['id'];
        $text = $update['message']['text'];
        return new UpdateDto($updateId, $userId, $text);
    }

}