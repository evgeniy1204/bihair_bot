<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;

class StartMessageBuilder implements MessageBuilderInterface
{

    private const EVENT = '/start';

    private const HELLO_MESSAGE_TEXT = 'Привет! 👋🏻
Жми "Курс" и скорее переходи смотреть мой бесплатный пробный урок 💇🏻‍♀️';

    /**
     * @param string $chatId
     *
     * @return MessageDto[]|\Generator
     */
    public function build(string $chatId): \Generator
    {
        yield new MessageDto(
            $chatId,
            self::HELLO_MESSAGE_TEXT,
            keyboardButtons: [
                new ButtonDto('💇‍♀️ Курс'),
                new ButtonDto('💫 Услуги'),
                new ButtonDto('📱 Мои соц. сети'),
                new ButtonDto('💬 Чат для мастеров'),
            ]);
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
