<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\ButtonDto;
use App\Domain\BiHairBot\MessageDto;

class ContactsMessageBuilder implements MessageBuilderInterface
{
    private const MESSAGE_TEXT = 'Мои соц. сети:';
    /**
     * @param string $chantId
     *
     * @return MessageDto[]|\Generator
     */
    public function build(string $chantId): \Generator
    {
        yield new MessageDto(
            $chantId,
            self::MESSAGE_TEXT, [
            new ButtonDto('Телеграм', url: 'https://t.me/bihair_sms'),
            new ButtonDto('Instagram', url: 'https://www.instagram.com/bihair__'),
            new ButtonDto('TikTok', url: 'https://www.tiktok.com/@bihair__'),
        ]);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return $type === BiHairBotEvents::CONTACTS;
    }
}
