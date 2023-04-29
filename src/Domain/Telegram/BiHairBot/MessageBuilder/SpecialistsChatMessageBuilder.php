<?php
namespace App\Domain\Telegram\BiHairBot\MessageBuilder;

use App\Domain\Telegram\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;
use App\Service\Telegram\UpdateDto;

class SpecialistsChatMessageBuilder implements MessageBuilderInterface
{
    public const EVENT = '💬 Чат для мастеров';

    private const MESSAGE_TEXT = 'Наш чат:';

    /**
     * @param UpdateDto $update
     * @return MessageDto[]|\Generator
     */
    public function build(UpdateDto $update): \Generator
    {
        yield new MessageDto(
            $update->getChatId(),
            self::MESSAGE_TEXT,
            [new ButtonDto('Курим, парим и хуярим', url: 'https://t.me/+0_uO4FSSSp8zZWVi')]
        );
    }

    /**
     * @param string $type
     * @param string $botName
     *
     * @return bool
     */
    public function supports(string $type, string $botName): bool
    {
        return $type === self::EVENT && $botName === BiHairBotProvider::BOT_NAME;
    }
}
