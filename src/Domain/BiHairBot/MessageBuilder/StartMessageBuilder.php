<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;
use App\Service\Telegram\UpdateDto;

class StartMessageBuilder implements MessageBuilderInterface
{

    public const EVENT = '/start';

    private const HELLO_MESSAGE_TEXT = 'Привет! 👋🏻
Жми "Курс" и скорее переходи смотреть мой бесплатный пробный урок 💇🏻‍♀️';

    /**
     * @param UpdateDto $update
     * @return MessageDto[]|\Generator
     */
    public function build(UpdateDto $update): \Generator
    {
        yield new MessageDto(
            $update->getChatId(),
            self::HELLO_MESSAGE_TEXT,
            keyboardButtons: [
                new ButtonDto(CourseMessageBuilder::EVENT),
                new ButtonDto(ServiceMessageBuilder::EVENT),
                new ButtonDto(ContactsMessageBuilder::EVENT),
                new ButtonDto(SpecialistsChatMessageBuilder::EVENT),
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
