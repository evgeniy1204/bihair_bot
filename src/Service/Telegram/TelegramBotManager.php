<?php
namespace App\Service\Telegram;

use App\Domain\BiHairBot\MessageBuilder\MessageBuilderInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

readonly class TelegramBotManager
{
    /**
     * @param MessageBuilderInterface[]|iterable $messageBuilders
     */
    public function __construct(
        #[TaggedIterator(tag: MessageBuilderInterface::TAG)] private iterable $messageBuilders,
        private TelegramApiClient $telegramApiClient
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $lastUpdateId = null;
        $updates = $this->telegramApiClient->getUpdates($lastUpdateId);
        while ($updates) {
            foreach ($updates as $update) {
                $this->sendMessage($update->getChatId(), $update->getKey());
                $lastUpdateId = $update->getUpdateId();
            }
            $updates = $this->telegramApiClient->getUpdates(++$lastUpdateId);
        }

    }

    /**
     * @param string $chantId
     * @param string $type
     *
     * @return void
     */
    public function sendMessage(string $chantId, string $type): void
    {
        $messages = $this->getMessageBuilder($type)?->build($chantId);
        if ($messages) {
            foreach ($messages as $message) {
                $this->telegramApiClient->sendMessage($message);
            }
        }
    }

    /**
     * @param string $type
     *
     * @return MessageBuilderInterface|null
     */
    private function getMessageBuilder(string $type): ?MessageBuilderInterface
    {
        foreach ($this->messageBuilders as $builder) {
            if ($builder->supports($type)) {
                return $builder;
            }
        }

        return null;
    }
}
