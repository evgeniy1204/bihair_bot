<?php

namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;

class StartMessageBuilder implements MessageBuilderInterface
{

    /**
     * @param string $chatId
     *
     * @return MessageDto[]|\Generator
     */
    public function build(string $chatId): \Generator
    {
        yield new MessageDto(
            $chatId,
            $this->getMessageText(),
            keyboardButtons: [
                new ButtonDto('💇‍♀️ Курс'),
                new ButtonDto('💫 Услуги'),
                new ButtonDto('📱 Мои соц. сети'),
                new ButtonDto('💬 Чат для мастеров'),
            ]
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
        return $type === BiHairBotEvents::START && $botName === BiHairBotProvider::BOT_NAME;
    }

    /**
     * @return string
     */
    private function getMessageText(): string
    {
        return 'Привет! 👋🏻
Жми "Курс" и скорее переходи смотреть мой бесплатный пробный урок 💇🏻‍♀️';
    }
}
