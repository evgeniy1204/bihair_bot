<?php
namespace App\Service\Telegram;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

readonly class TelegramBotManager
{
    /**
     * @param MessageBuilderInterface[]|iterable $messageBuilders
     * @param BotProviderInterface[]|iterable    $bots
     */
    public function __construct(
        #[TaggedIterator(tag: MessageBuilderInterface::TAG)] private iterable $messageBuilders,
        #[TaggedIterator(tag: BotProviderInterface::BOT_PROVIDER)] private iterable $bots,
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        foreach ($this->bots as $bot) {
            $telegramBotClient = new TelegramApiClient($bot->getToken());
            $lastUpdateId = null;
            $updates = $telegramBotClient->getUpdates($lastUpdateId);
            while ($updates) {
                foreach ($updates as $update) {
                    $messages = $this->getMessageBuilder($update->getKey(), $bot->getName())?->build($update);
                    if ($messages) {
                        foreach ($messages as $message) {
                            $telegramBotClient->sendMessage($message);
                        }
                    }
                    $lastUpdateId = $update->getUpdateId();
                }
                $updates = $telegramBotClient->getUpdates(++$lastUpdateId);
            }
        }
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
