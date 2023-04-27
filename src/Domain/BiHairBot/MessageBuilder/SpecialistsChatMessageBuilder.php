<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;

class SpecialistsChatMessageBuilder implements MessageBuilderInterface
{
    private const EVENT = '💬 Чат для мастеров';

    private const MESSAGE_TEXT = 'Наш чат:';
    /**
     * @param string $chatId
     *
     * @return MessageDto[]|\Generator
     */
    public function build(string $chatId): \Generator
    {
        yield new MessageDto(
            $chatId,
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
