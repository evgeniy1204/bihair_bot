<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;

class ContactsMessageBuilder implements MessageBuilderInterface
{
    private const MESSAGE_TEXT = 'Мои соц. сети:';
    /**
     * @param string $chatId
     *
     * @return MessageDto[]|\Generator
     */
    public function build(string $chatId): \Generator
    {
        yield new MessageDto(
            $chatId,
            self::MESSAGE_TEXT, [
            new ButtonDto('Телеграм', url: 'https://t.me/bihair_sms'),
            new ButtonDto('Instagram', url: 'https://www.instagram.com/bihair__'),
            new ButtonDto('TikTok', url: 'https://www.tiktok.com/@bihair__'),
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
        return $type === BiHairBotEvents::CONTACTS && $botName === BiHairBotProvider::BOT_NAME;
    }
}
