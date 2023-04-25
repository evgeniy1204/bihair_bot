<?php
namespace App\Domain\BiHairBot\Manager;

use App\Domain\BiHairBot\MessageBuilder\MessageBuilderInterface;
use App\Domain\BiHairBot\MessageDto;
use App\Service\Telegram\TelegramApiClient;
use App\Service\Telegram\UpdateHandler;
use LogicException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

readonly class TelegramBotManager
{
    /**
     * @param MessageBuilderInterface[]|iterable $messageBuilders
     */
    public function __construct(
        #[TaggedIterator(tag: MessageBuilderInterface::TAG)] private iterable $messageBuilders,
        private UpdateHandler $updateHandler,
        private TelegramApiClient $telegramApiClient
    ) {
    }

    public function handle()
    {
        $arr = $this->updateHandler->handle();
        foreach ($arr as $a){
            echo $a->getText();
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
        $message = $this->getMessageBuilder($type)->build();

        $this->telegramApiClient->sendMessage($chantId, $message);
    }

    /**
     * @param string $type
     *
     * @return MessageBuilderInterface
     */
    private function getMessageBuilder(string $type): MessageBuilderInterface
    {
        foreach ($this->messageBuilders as $builder) {
            if ($builder->supports($type)) {
                return $builder;
            }
        }

        throw new LogicException('Unsupported message builder type');
    }
}
