<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;

class ContactsMessageBuilder implements MessageBuilderInterface
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
            $this->getMessageText(), [
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

    /**
     * @return string
     */
    private function getMessageText() : string
    {
        return 'Мои соц. сети:';
    }
}
