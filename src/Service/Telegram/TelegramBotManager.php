<?php

namespace App\Service\Telegram;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

readonly class TelegramBotManager
{
    /**
     * @param MessageBuilderInterface[]|iterable $messageBuilders
     * @param BotProviderInterface[]|iterable $bots
     */
    public function __construct(
        #[TaggedIterator(tag: MessageBuilderInterface::TAG)] private iterable $messageBuilders,
        #[TaggedIterator(tag: BotProviderInterface::BOT_PROVIDER)] private iterable $bots,
    ) {
    }

    /**
     * @return void
     */
    public function handleGetUpdates(): void
    {
        foreach ($this->bots as $bot) {
            $telegramBotClient = new TelegramApiClient($bot->getToken());
            $lastUpdateId = null;
            $updates = $telegramBotClient->getUpdates($lastUpdateId);
            while ($updates) {
                foreach ($updates as $update) {
                    if ($updateDto = $this->createUpdate($update)) {
                        $this->processUpdate($updateDto, $bot, $telegramBotClient);
                        $lastUpdateId = $updateDto->getUpdateId();
                    };
                }
                $updates = $telegramBotClient->getUpdates(++$lastUpdateId);
            }
        }
    }

    public function processUpdate(UpdateDto$update, BotProviderInterface $bot, TelegramApiClient $telegramBotClient): void
    {
        $messages = $this->getMessageBuilder($update->getKey(), $bot->getName())?->build($update);

        if ($messages) {
            foreach ($messages as $message) {
                $telegramBotClient->sendMessage($message);
            }
        }
    }

    private function createUpdate(array $result): ?UpdateDto
    {
        $callbackData = null;
        if ($result['callback_query'] ?? null) {
            $callbackData = $result['callback_query']['data'];

            return new UpdateDto(
                $result['update_id'], $result['callback_query']['message']['chat']['id'], $callbackData
            );
        }
        $chatId = $result['message']['chat']['id'] ?? null;
        $key = $callbackData ?? $result['message']['text'] ?? null;
        $id = $result['update_id'] ?? null;

        if ($id && $chatId && $key) {
            return new UpdateDto($id, $chatId, $key);
        }

        return null;
    }

    /**
     * @param string $type
     * @param string $botName
     *
     * @return MessageBuilderInterface|null
     */
    private function getMessageBuilder(string $type, string $botName): ?MessageBuilderInterface
    {
        foreach ($this->messageBuilders as $builder) {
            if ($builder->supports($type, $botName)) {
                return $builder;
            }
        }

        return null;
    }
}
