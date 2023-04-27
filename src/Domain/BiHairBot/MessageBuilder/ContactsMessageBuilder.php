<?php

namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;
use App\Service\Telegram\UpdateDto;

class ContactsMessageBuilder implements MessageBuilderInterface
{

    public const EVENT = '📱 Мои соц. сети';

    private const MESSAGE_TEXT = 'Мои соц. сети:';

    /**
     * @param UpdateDto $update
     * @return MessageDto[]|\Generator
     */
    public function build(UpdateDto $update): array|\Generator
    {
        yield new MessageDto(
            $update->getChatId(),
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
        return $type === self::EVENT && $botName === BiHairBotProvider::BOT_NAME;
    }
}
