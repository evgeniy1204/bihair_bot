<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\ButtonDto;
use App\Domain\BiHairBot\MessageDto;

class StartMessageBuilder implements MessageBuilderInterface
{
    private const HELLO_MESSAGE_TEXT = 'Привет! 👋🏻
Жми "Курс" и скорее переходи смотреть мой бесплатный пробный урок 💇🏻‍♀️';
    /**
     * @param string $chantId
     *
     * @return MessageDto[]|\Generator
     */
    public function build(string $chantId): \Generator
    {
        yield new MessageDto(
            $chantId,
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
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return $type === BiHairBotEvents::START;
    }
}
