<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;
use App\Service\Telegram\UpdateDto;

class ServiceMessageBuilder implements MessageBuilderInterface
{
    public const EVENT = '💫 Услуги';

    /**
     * @param UpdateDto $update
     * @return MessageDto[]|\Generator
     */
    public function build(UpdateDto $update): \Generator
    {
        yield new MessageDto(
            $update->getChatId(),
            'Кератин 
💫 Кератин - процедура выпрямления завитков, кудрей, волнистых волос и формирования защитной пленки вокруг волоса для блеска, утяжеления и идеальной гладкости

💫 Ботокс - процедура дисциплинирования волос, сглаживания пушистости для идеально гладких блестящих волос',
            photoId: 'AgACAgQAAxkDAAMMZEky0t0tjivXyb8kzBn8EcVEWcQAApSvMRsVDE1SRlyO0LIfb20BAAMCAANzAAMvBA'
        );
        yield new MessageDto(
            $update->getChatId(),
            'Холодное восстановление
💫 Холодное восстановление нужно самым хрупким, ломким, обесцвеченным, поврежденным волосам. Без использования утюжка. Не имеет ярко выраженных визуальных эффектов',
            photoId: 'AgACAgQAAxkDAAMNZEky-rVZayT9D8bf1yfq6hA3qz8AAtSvMRtOKExSyN2348Dav1QBAAMCAANzAAMvBA'
        );
        yield new MessageDto(
            $update->getChatId(),
            'Трихология',
            [new ButtonDto('Подробноее о трихологии', url: 'https://www.instagram.com/s/aGlnaGxpZ2h0OjE4MDUwOTY3Nzc1Mzk3NTc3?story_media_id=3057605334607647085&igshid=YmMyMTA2M2Y=')]
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
